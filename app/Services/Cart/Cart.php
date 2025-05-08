<?php

declare(strict_types=1);

namespace App\Services\Cart;

use App\Helper;
use Closure;
use DateTime;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class Cart
{
    const DEFAULT_INSTANCE = 'default';

    private int $shippingId = 0;

    /**
     * The address id of the user placing the order used to get the country for the delivery method
     */
    private int $addressId = 0;

    private array $shippingSet = [];

    /**
     * Holds the current cart instance.
     */
    private string $instance;

    /**
     * Cart constructor.
     */
    public function __construct(/**
     * Instance of the session manager.
     */
        protected SessionManager $session, /**
     * Instance of the event dispatcher.
     */
        private readonly Dispatcher $dispatcher)
    {
        $this->instance(self::DEFAULT_INSTANCE);
    }

    /**
     * Set the current cart instance.
     *
     * @return $this
     */
    public function instance($instance = null): static
    {
        $instance = $instance ?: self::DEFAULT_INSTANCE;

        $this->instance = sprintf('%s.%s', 'cart', $instance);

        return $this;
    }

    public function add($id, $name = null, $qty = null, $price = null, array $options = [], $taxrate = null)
    {
        if ($this->isMulti($id)) {
            return array_map(fn ($item) => $this->add($item), $id);
        }

        $cartItem = $id instanceof CartItem ? $id : $this->createCartItem($id, $name, $qty, $price, $options, $taxrate);

        $content = $this->getContent();

        if ($content->has($cartItem->rowId)) {
            $cartItem->qty += $content->get($cartItem->rowId)->qty;
        }

        $content->put($cartItem->rowId, $cartItem);

        $this->dispatcher->dispatch('cart.added', $cartItem);

        $this->session->put($this->instance, $content);

        return $cartItem;
    }

    /**
     * Check if the item is a multidimensional array or an array of Buyables.
     *
     * @param  mixed  $item
     * @return bool
     */
    private function isMulti($item)
    {
        if (! is_array($item)) {
            return false;
        }

        return is_array(head($item)) || head($item) instanceof Buyable;
    }

    private function createCartItem($id, $name, $qty, $price, array $options, $taxrate)
    {
        if ($id instanceof Buyable) {
            $cartItem = CartItem::fromBuyable($id, $qty ?: []);
            $cartItem->setQuantity($name ?: 1);
            $cartItem->associate($id);
        } elseif (is_array($id)) {
            $cartItem = CartItem::fromArray($id);
            $cartItem->setQuantity($id['qty']);
        } else {
            $cartItem = CartItem::fromAttributes($id, $name, $price, $options);
            $cartItem->setQuantity($qty);
        }

        if (isset($taxrate) && is_numeric($taxrate)) {
            $cartItem->setTaxRate($taxrate);
        } else {
            $cartItem->setTaxRate(config('cart.tax'));
        }

        return $cartItem;
    }

    /**
     * Associate the cart item with the given rowId with the given model.
     *
     * @param  string  $rowId
     * @param  mixed  $model
     */
    public function associate($rowId, $model): void
    {
        if (is_string($model) && ! class_exists($model)) {
            throw new UnknownModelException(sprintf('The supplied model %s does not exist.', $model));
        }

        $cartItem = $this->get($rowId);

        $cartItem->associate($model);

        $content = $this->getContent();

        $content->put($cartItem->rowId, $cartItem);

        $this->session->put($this->instance, $content);
    }

    public function get($rowId)
    {
        $content = $this->getContent();

        if (! $content->has($rowId)) {
            throw new InvalidRowIDException(sprintf('The cart does not contain rowId %s.', $rowId));
        }

        return $content->get($rowId);
    }

    /**
     * Get the carts content, if there is no cart content set yet, return a new empty Collection
     *
     * @return Collection
     */
    protected function getContent()
    {
        return $this->session->has($this->instance)
            ? $this->session->get($this->instance)
            : new Collection;
    }

    public function update($rowId, $qty)
    {
        $cartItem = $this->get($rowId);

        if ($qty instanceof Buyable) {
            $cartItem->updateFromBuyable($qty);
        } elseif (is_array($qty)) {
            $cartItem->updateFromArray($qty);
        } else {
            $cartItem->qty = $qty;
        }

        $content = $this->getContent();

        if ($rowId !== $cartItem->rowId) {
            $content->pull($rowId);

            if ($content->has($cartItem->rowId)) {
                $existingCartItem = $this->get($cartItem->rowId);
                $cartItem->setQuantity($existingCartItem->qty + $cartItem->qty);
            }
        }

        if ($cartItem->qty <= 0) {
            $this->remove($cartItem->rowId);

            return null;
        }

        $content->put($cartItem->rowId, $cartItem);

        $this->dispatcher->dispatch('cart.updated', $cartItem);

        $this->session->put($this->instance, $content);

        return $cartItem;
    }

    /**
     * Remove the cart item with the given rowId from the cart.
     *
     * @param  string  $rowId
     */
    public function remove($rowId): void
    {
        $cartItem = $this->get($rowId);

        $content = $this->getContent();

        $content->pull($cartItem->rowId);

        $this->dispatcher->dispatch('cart.removed', $cartItem);

        $this->session->put($this->instance, $content);
    }

    /**
     * Destroy the current cart instance.
     */
    public function destroy(): void
    {
        $this->session->remove($this->instance);
    }

    /**
     * Get the content of the cart.
     *
     * @return Collection
     */
    public function content()
    {
        if (is_null($this->session->get($this->instance))) {
            return new Collection([]);
        }

        return $this->session->get($this->instance);
    }

    public function getShippingType(): void
    {
        $content = $this->getContent();

        $bySellers = [];
        $this->shippingSet = [];

        foreach ($content as $item) {
            $bySellers[$item->model->seller_id][] = $item->model->id;
        }

    }

    /**
     * Search the cart content for a cart item matching the given search closure.
     *
     * @return Collection
     */
    public function search(Closure $search)
    {
        $content = $this->getContent();

        return $content->filter($search);
    }

    /**
     * Set the tax rate for the cart item with the given rowId.
     *
     * @param  string  $rowId
     * @param  int|float  $taxRate
     */
    public function setTax($rowId, $taxRate): void
    {
        $cartItem = $this->get($rowId);

        $cartItem->setTaxRate($taxRate);

        $content = $this->getContent();

        $content->put($cartItem->rowId, $cartItem);

        $this->session->put($this->instance, $content);
    }

    public function setShippingId(int $shippingId): void
    {
        $this->shippingId = $shippingId;
    }

    /**
     * Set the tax rate for the cart item with the given rowId.
     *
     * @param  string  $rowId
     * @param  int|float  $taxRate
     */
    public function setShipping($rowId, $shippingId, $shippingPrice): void
    {
        $content = $this->getContent();

        if (config('shop.shipping_calculation') === 'per_item') {
            foreach ($content as $item) {
                $item->setShippingRate($shippingId, $shippingPrice);
                $content->put($item->rowId, $item);
            }
        } else {
            foreach ($content as $item) {
                $price = $shippingPrice / $content->count();
                $item->setShippingRate($shippingId, $price);
                $content->put($item->rowId, $item);
            }
        }

        $this->session->put($this->instance, $content);
    }

    /**
     * Get the number of items in the cart.
     *
     * @return int|float
     */
    public function count()
    {
        $content = $this->getContent();

        return $content->sum('qty');
    }

    /**
     * Store an the current instance of the cart.
     *
     * @param  mixed  $identifier
     */
    public function store($identifier): void
    {
        $content = $this->getContent();

        $this->getConnection()
            ->table($this->getTableName())
            ->where('identifier', $identifier)
            ->where('instance', $this->currentInstance())
            ->delete();

        $this->getConnection()->table($this->getTableName())->insert([
            'identifier' => $identifier,
            'instance' => $this->currentInstance(),
            'content' => serialize($content),
            'created_at' => new DateTime,
        ]);

        $this->dispatcher->dispatch('cart.stored');
    }

    /**
     * Get the database connection.
     *
     * @return Connection
     */
    protected function getConnection()
    {
        $connectionName = $this->getConnectionName();

        return app(DatabaseManager::class)->connection($connectionName);
    }

    /**
     * Get the database connection name.
     *
     * @return string
     */
    private function getConnectionName()
    {
        $connection = config('cart.database.connection');

        return is_null($connection) ? config('database.default') : $connection;
    }

    /**
     * Get the database table name.
     *
     * @return string
     */
    protected function getTableName()
    {
        return config('cart.database.table', 'shoppingcart');
    }

    /**
     * Get the current cart instance.
     */
    public function currentInstance(): string
    {
        return str_replace('cart.', '', $this->instance);
    }

    /**
     * Restore the cart with the given identifier.
     *
     * @param  mixed  $identifier
     */
    public function restore($identifier): void
    {
        if (! $this->storedCartWithIdentifierExists($identifier)) {
            return;
        }

        $stored = $this->getConnection()->table($this->getTableName())
            ->where('instance', $this->currentInstance())
            ->where('identifier', $identifier)->first();

        $storedContent = unserialize(data_get($stored, 'content'));

        $currentInstance = $this->currentInstance();

        $this->instance(data_get($stored, 'instance'));

        $content = $this->getContent();

        foreach ($storedContent as $cartItem) {
            $content->put($cartItem->rowId, $cartItem);
        }

        $this->dispatcher->dispatch('cart.restored');

        $this->session->put($this->instance, $content);

        $this->instance($currentInstance);

    }

    /**
     * @return bool
     */
    protected function storedCartWithIdentifierExists($identifier)
    {
        return $this->getConnection()->table($this->getTableName())->where('identifier', $identifier)->where('instance', $this->currentInstance())->exists();
    }

    public function loadWishlistProducts(): void
    {
        if (Session::has('wishlist_products')) {
            return;
        }

        $stored = $this->getConnection()->table($this->getTableName())
            ->where('instance', $this->currentInstance())->get();

        $wishlistProducts = [];

        foreach ($stored as $cartItem) {
            $storedContent = unserialize(data_get($cartItem, 'content'));

            foreach ($storedContent as $cartItemRow) {
                if (! isset($wishlistProducts[$cartItemRow->id])) {
                    $wishlistProducts[$cartItemRow->id] = 1;

                    continue;
                }

                $wishlistProducts[$cartItemRow->id]++;
            }
        }

        $this->session->put('wishlist_products', $wishlistProducts);
    }

    /**
     * @return list<mixed>
     */
    public function getStoredItems(): array
    {

        $stored = $this->getConnection()->table($this->getTableName())
            ->where('instance', $this->currentInstance())->get();

        $wishlistProducts = [];

        foreach ($stored as $cartItem) {
            $storedContent = unserialize(data_get($cartItem, 'content'));

            foreach ($storedContent as $cartItemRow) {

                $cartItemRow->identifier = $cartItem->identifier;

                $wishlistProducts[] = $cartItemRow;
            }
        }

        return $wishlistProducts;
    }

    /**
     * Deletes the stored cart with given identifier
     *
     * @param  mixed  $identifier
     */
    public function deleteStoredCart($identifier): void
    {
        $this->getConnection()
            ->table($this->getTableName())
            ->where('identifier', $identifier)
            ->delete();
    }

    /**
     * Magic method to make accessing the total, tax and subtotal properties possible.
     *
     * @param  string  $attribute
     * @return float|null
     */
    public function __get($attribute)
    {
        if ($attribute === 'total') {
            return $this->total();
        }

        if ($attribute === 'tax') {
            return $this->tax();
        }

        if ($attribute === 'subtotal') {
            return $this->subtotal();
        }

        return null;
    }

    /**
     * Get the total price of the items in the cart.
     *
     * @param  int  $decimals
     * @param  string  $decimalPoint
     * @param  string  $thousandSeperator
     */
    public function total($decimals = null, $decimalPoint = null, $thousandSeperator = null): string
    {
        $content = $this->getContent();

        $total = $content->reduce(fn ($total, CartItem $cartItem): float|int => $total + ($cartItem->qty * $cartItem->priceTax), 0);

        $total += $this->shipping() + $this->commission();

        return $this->numberFormat($total, $decimals, $decimalPoint, $thousandSeperator);
    }

    public function setAddressId(int $addressId): void
    {
        $this->addressId = $addressId;
    }

    /**
     * Get the total shipping of the items in the cart.
     *
     * @param  int  $decimals
     * @param  string  $decimalPoint
     * @param  string  $thousandSeperator
     */
    public function shipping($decimals = null, $decimalPoint = null, $thousandSeperator = null): string
    {
        $content = $this->getContent();

        $bySellers = [];
        $this->shippingSet = [];
        foreach ($content as $item) {
            $bySellers[$item->model->seller_id][] = $item->model->id;
        }

        $shipping = $content->reduce(function ($shipping, CartItem $cartItem) use ($bySellers) {
            if (isset($this->shippingSet[$cartItem->model->seller_id])) {
                return $shipping;
            }

            if (isset($bySellers[$cartItem->model->seller_id]) && count($bySellers[$cartItem->model->seller_id]) > 1) {
                $this->shippingSet[$cartItem->model->seller_id] = true;

                return $shipping + $cartItem->shipping(true, $this->addressId, $this->shippingId);
            }

            return $shipping + $cartItem->shipping(false, $this->addressId, $this->shippingId);
        }, 0);

        return $this->numberFormat($shipping, $decimals, $decimalPoint, $thousandSeperator);
    }

    /**
     * Get the Formated number
     */
    private function numberFormat($value, $decimals, $decimalPoint, $thousandSeperator): string
    {
        if (is_null($decimals)) {
            $decimals = is_null(config('cart.format.decimals')) ? 2 : config('cart.format.decimals');
        }

        if (is_null($decimalPoint)) {
            $decimalPoint = is_null(config('cart.format.decimal_point')) ? '.' : config('cart.format.decimal_point');
        }

        if (is_null($thousandSeperator)) {
            $thousandSeperator = is_null(config('cart.format.thousand_seperator')) ? ',' : config('cart.format.thousand_seperator');
        }

        return number_format($value, $decimals, $decimalPoint, $thousandSeperator);
    }

    public function commission()
    {
        return Helper::calculateCommission($this->getSubtotal());

    }

    /**
     * Get the subtotal (total - tax) of the items in the cart.
     *
     * @param  int  $decimals
     * @param  string  $decimalPoint
     * @param  string  $thousandSeperator
     */
    public function subtotal($decimals = null, $decimalPoint = null, $thousandSeperator = null): string
    {
        return $this->numberFormat($this->getSubtotal(), $decimals, $decimalPoint, $thousandSeperator);
    }

    public function getSubtotal(): float {
        $content = $this->getContent();

        return $content->reduce(fn ($subTotal, CartItem $cartItem): int|float => $subTotal + ($cartItem->qty * $cartItem->price), 0);
    }

    /**
     * Get the total tax of the items in the cart.
     *
     * @param  int  $decimals
     * @param  string  $decimalPoint
     * @param  string  $thousandSeperator
     */
    public function tax($decimals = null, $decimalPoint = null, $thousandSeperator = null): string
    {
        $content = $this->getContent();

        $tax = $content->reduce(fn ($tax, CartItem $cartItem): float|int => $tax + ($cartItem->qty * $cartItem->tax), 0);

        return $this->numberFormat($tax, $decimals, $decimalPoint, $thousandSeperator);
    }
}
