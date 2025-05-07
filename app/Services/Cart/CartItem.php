<?php

declare(strict_types=1);

namespace App\Services\Cart;

use App\Models\Address;
use App\Models\DeliveryMethod;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class CartItem implements Arrayable, Jsonable
{
    /**
     * The rowID of the cart item.
     *
     * @var string
     */
    public $rowId;

    /**
     * The ID of the cart item.
     *
     * @var int|string
     */
    public $id;

    /**
     * The quantity for this cart item.
     *
     * @var int|float
     */
    public $qty;

    /**
     * The name of the cart item.
     *
     * @var string
     */
    public $name;

    /**
     * The price without TAX of the cart item.
     *
     * @var float
     */
    public $price;

    /**
     * The options for this cart item.
     *
     * @var array
     */
    public $options;

    /**
     * The address id of the user placing the order used to get the country for the delivery method
     */
    private int $addressId = 0;

    /**
     * The selected delivery method
     */
    private DeliveryMethod $deliveryMethod;

    /**
     * The FQN of the associated model.
     */
    private ?string $associatedModel = null;

    /**
     * The tax rate for the cart item.
     *
     * @var int|float
     */
    private $taxRate = 0;

    /**
     * @var int
     */
    private $shippingId = 0;

    /**
     * @var int|float
     */
    private $shippingPrice = 0;

    /**
     * Is item saved for later.
     *
     * @var bool
     */
    private $isSaved = false;

    /**
     * CartItem constructor.
     *
     * @param  int|string  $id
     * @param  string  $name
     * @param  float  $price
     */
    public function __construct($id, $name, $price, array $options = [])
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Please supply a valid identifier.');
        }

        if (empty($name)) {
            throw new InvalidArgumentException('Please supply a valid name.');
        }

        if (strlen($price) < 0 || ! is_numeric($price)) {
            throw new InvalidArgumentException('Please supply a valid price.');
        }

        $this->id = $id;
        $this->name = $name;
        $this->price = floatval($price);
        $this->options = new CartItemOptions($options);
        $this->rowId = $this->generateRowId($id, $options);
    }

    /**
     * Generate a unique id for the cart item.
     */
    protected function generateRowId(string $id, array $options): string
    {
        ksort($options);

        return md5($id.serialize($options));
    }

    /**
     * Create a new instance from a Buyable.
     */
    public static function fromBuyable(Buyable $buyable, array $options = []): self
    {
        return new self($buyable->getBuyableIdentifier($options), $buyable->getBuyableDescription($options), $buyable->getBuyablePrice($options), $options);
    }

    /**
     * Create a new instance from the given array.
     *
     * @return \Surfsidemedia\Shoppingcart\CartItem
     */
    public static function fromArray(array $attributes): self
    {
        $options = Arr::get($attributes, 'options', []);

        return new self($attributes['id'], $attributes['name'], $attributes['price'], $options);
    }

    /**
     * Create a new instance from the given attributes.
     */
    public static function fromAttributes($id, $name, $price, array $options = []): self
    {
        return new self($id, $name, $price, $options);
    }

    /**
     * Returns the formatted price without TAX.
     *
     * @param  int  $decimals
     * @param  string  $decimalPoint
     * @param  string  $thousandSeperator
     */
    public function price($decimals = null, $decimalPoint = null, $thousandSeperator = null): string
    {
        return $this->numberFormat($this->price, $decimals, $decimalPoint, $thousandSeperator);
    }

    /**
     * Get the formatted number.
     *
     * @param  float  $value
     * @param  int  $decimals
     * @param  string  $decimalPoint
     * @param  string  $thousandSeperator
     */
    private function numberFormat($value, $decimals = null, $decimalPoint = null, $thousandSeperator = null): string
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

    /**
     * Returns the formatted price with TAX.
     *
     * @param  int  $decimals
     * @param  string  $decimalPoint
     * @param  string  $thousandSeperator
     */
    public function priceTax($decimals = null, $decimalPoint = null, $thousandSeperator = null): string
    {
        return $this->numberFormat($this->priceTax, $decimals, $decimalPoint, $thousandSeperator);
    }

    /**
     * Returns the formatted price with TAX.
     *
     * @param  int  $decimals
     * @param  string  $decimalPoint
     * @param  string  $thousandSeperator
     */
    public function shipping(bool $hasBulk = false, int $addressId = 0, int $deliveryMethodId = 0, $decimals = null, $decimalPoint = null, $thousandSeperator = null): float
    {
        $this->addressId = $addressId;

        if ($hasBulk) {
            $shippingPrice = config('shop.bulk_price');
        } else {
            $this->deliveryMethod = $this->getShippingId($hasBulk, $deliveryMethodId);

            if (empty($this->deliveryMethod)) {
                throw new InvalidArgumentException('Please supply a valid delivery method.');
            }

            $shippingPrice = $this->deliveryMethod->price;
        }

        return $this->numberFormat($shippingPrice, $decimals, $decimalPoint, $thousandSeperator);
    }

    public function getDeliveryMethod(): DeliveryMethod
    {
        return $this->deliveryMethod;
    }

    public function getShippingId($hasBulk = false, int $deliveryMethodId = 0)
    {
        $packageSize = $hasBulk === true ? 'Bulk' : $this->getPackageSize();
        $address = ($this->addressId === 0) ? (auth()->check() ? auth()->user()->defaultAddress() : null) : (Address::whereId($this->addressId)->first());

        $query = DeliveryMethod::query()
            ->with('courier')
            ->where('name', $packageSize);

        if (! empty($address)) {
            $query = $query->where('country_id', $address->country_id);
        }

        if ($deliveryMethodId !== 0) {
            $deliveryMethod = DeliveryMethod::whereId($deliveryMethodId)->first();
            $deliveryMethod->name = 'Small';

            if (! empty($deliveryMethod)) {
                // if the package size and the selected delivery method match use that
                if ($deliveryMethod->name == $packageSize) {
                    return $deliveryMethod;
                }

                // otherwise check to see if we have a match for the same courier and package size
                $query = $query->where('courier_id', $deliveryMethod->courier_id);
            }
        }

        return $query->first();
    }

    public function getPackageSize()
    {
        $product = $this->model;

        $size = $product->package_size;

        if (empty($size)) {
            return 'Small';
        }

        return $size;
    }

    public function setAddressId(int $addressId) {}

    /**
     * Returns the formatted subtotal.
     * Subtotal is price for whole CartItem without TAX
     *
     * @param  int  $decimals
     * @param  string  $decimalPoint
     * @param  string  $thousandSeperator
     */
    public function subtotal($decimals = null, $decimalPoint = null, $thousandSeperator = null): string
    {
        return $this->numberFormat($this->subtotal, $decimals, $decimalPoint, $thousandSeperator);
    }

    /**
     * Returns the formatted total.
     * Total is price for whole CartItem with TAX
     *
     * @param  int  $decimals
     * @param  string  $decimalPoint
     * @param  string  $thousandSeperator
     */
    public function total($decimals = null, $decimalPoint = null, $thousandSeperator = null): string
    {
        return $this->numberFormat($this->total, $decimals, $decimalPoint, $thousandSeperator);
    }

    /**
     * Returns the formatted tax.
     *
     * @param  int  $decimals
     * @param  string  $decimalPoint
     * @param  string  $thousandSeperator
     */
    public function tax($decimals = null, $decimalPoint = null, $thousandSeperator = null): string
    {
        return $this->numberFormat($this->tax, $decimals, $decimalPoint, $thousandSeperator);
    }

    /**
     * Returns the formatted tax.
     *
     * @param  int  $decimals
     * @param  string  $decimalPoint
     * @param  string  $thousandSeperator
     */
    public function taxTotal($decimals = null, $decimalPoint = null, $thousandSeperator = null): string
    {
        return $this->numberFormat($this->taxTotal, $decimals, $decimalPoint, $thousandSeperator);
    }

    /**
     * Set the quantity for this cart item.
     *
     * @param  int|float  $qty
     */
    public function setQuantity($qty): void
    {
        if (empty($qty) || ! is_numeric($qty)) {
            throw new InvalidArgumentException('Please supply a valid quantity.');
        }

        $this->qty = $qty;
    }

    /**
     * Update the cart item from a Buyable.
     */
    public function updateFromBuyable(Buyable $buyable): void
    {
        $this->id = $buyable->getBuyableIdentifier($this->options);
        $this->name = $buyable->getBuyableDescription($this->options);
        $this->price = $buyable->getBuyablePrice($this->options);
        $this->priceTax = $this->price + $this->tax;
    }

    /**
     * Update the cart item from an array.
     */
    public function updateFromArray(array $attributes): void
    {
        $this->id = Arr::get($attributes, 'id', $this->id);
        $this->qty = Arr::get($attributes, 'qty', $this->qty);
        $this->name = Arr::get($attributes, 'name', $this->name);
        $this->price = Arr::get($attributes, 'price', $this->price);
        $this->priceTax = $this->price + $this->tax;
        $this->options = new CartItemOptions(Arr::get($attributes, 'options', $this->options));

        $this->rowId = $this->generateRowId($this->id, $this->options->all());
    }

    /**
     * Associate the cart item with the given model.
     *
     * @return $this
     */
    public function associate($model): static
    {
        $this->associatedModel = is_string($model) ? $model : $model::class;

        return $this;
    }

    /**
     * Set the tax rate.
     *
     * @return $this
     */
    public function setTaxRate($taxRate): static
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function setShippingRate($shippingId, $shippingPrice): static
    {
        $this->shippingId = $shippingId;
        $this->shippingPrice = $shippingPrice;

        return $this;
    }

    public function setShippingPrice($shippingPrice): static
    {
        $this->shippingPrice = $shippingPrice;

        return $this;
    }

    /**
     * Set saved state.
     *
     * @return $this
     */
    public function setSaved($bool): static
    {
        $this->isSaved = $bool;

        return $this;
    }

    /**
     * Get an attribute from the cart item or get the associated model.
     *
     * @param  string  $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        if (property_exists($this, $attribute)) {
            return $this->{$attribute};
        }

        if ($attribute === 'priceTax') {
            return number_format(($this->price + $this->tax), 2, '.', '');
        }

        if ($attribute === 'shipping') {
            return $this->shippingPrice;
        }

        if ($attribute === 'shipping_id') {
            return $this->shippingId;
        }

        if ($attribute === 'subtotal') {
            return number_format(($this->qty * $this->price), 2, '.', '');
        }

        if ($attribute === 'total') {
            return number_format(($this->qty * $this->priceTax), 2, '.', '');
        }

        if ($attribute === 'tax') {
            return number_format(($this->price * ($this->taxRate / 100)), 2, '.', '');
        }

        if ($attribute === 'taxTotal') {
            return number_format(($this->tax * $this->qty), 2, '.', '');
        }

        if ($attribute === 'model' && $this->associatedModel !== null) {
            return with(new $this->associatedModel)->find($this->id);
        }

        return null;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        if ($this->associatedModel !== null) {

            return json_encode(array_merge($this->toArray(), ['model' => $this->model]), $options);
        }

        return json_encode($this->toArray(), $options);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'rowId' => $this->rowId,
            'id' => $this->id,
            'name' => $this->name,
            'qty' => $this->qty,
            'price' => $this->price,
            'options' => $this->options->toArray(),
            'tax' => $this->tax,
            'isSaved' => $this->isSaved,
            'subtotal' => $this->subtotal,
        ];
    }
}
