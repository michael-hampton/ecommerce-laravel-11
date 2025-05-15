<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Country;
use App\Models\Courier;
use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\Product;
use App\Models\SellerBalance;
use App\Models\SellerWithdrawal;
use App\Models\User;
use App\Services\Cart\Facade\Cart;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seller = User::factory()->create();
        Sanctum::actingAs($this->seller, ['*']);
    }

    public function test_fails_validation()
    {
        Order::factory()->create();

        $payload = [
            'status' => '',
        ];

        $order = Order::first();

        $this->json('put', "api/orders/$order->id", $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    'success' => false,
                    'message' => "Validation failed.",
                    'errors' => [
                        'status' => [
                            'The status field is required.'
                        ]
                    ]
                ]
            );
    }

    public function test_get_all_orders()
    {
        $this->json('get', 'api/orders?page=1&limit=10&sortBy=name&sortDir=asc')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'slug',
                            'image'
                        ],
                    ],
                ]
            )->assertJsonFragment(['current_page' => 1, 'per_page' => 10]);
    }

    // public function test_create_product_successful()
    // {
    //     $word = $this->faker->word();
    //     $payload = [
    //         'name' => $word,
    //         'slug' => Str::slug($word),
    //         'image' => UploadedFile::fake()->image('file1.png', 600, 600)
    //     ];

    //     $this->json('post', 'api/orders', $payload)
    //         ->assertStatus(200)
    //         ->assertJsonStructure(
    //             [
    //                 'data' => [
    //                     'id',
    //                     'name',
    //                     'slug',
    //                     'image'
    //                 ]
    //             ]
    //         );

    //     unset($payload['image']);
    //     $this->assertDatabaseHas('orders', $payload);
    // }


    // public function testUserIsDestroyed()
    // {

    //     $payload = [
    //         'name' => $this->faker->word(),
    //         'slug' => $this->faker->slug(),
    //         'deleted_at' => null
    //     ];
    //     $user = Order::create(
    //         $payload
    //     );

    //     $this->json('delete', "api/orders/$user->id")
    //         ->assertStatus(200);
    //     $this->assertDatabaseMissing('orders', $payload);
    // }

    public function testUpdateUserReturnsCorrectData()
    {
        Order::factory()->create();

        $courier = Courier::factory()->create();

        $payload = [
            'status' => 'delivered',
            'courier_id' => Courier::first()->id,
            'tracking_number' => $this->faker->word()
        ];

        $this->json('put', "api/orders/$courier->id", $payload)
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'message' => 'Order updated',
                    'success' => true,
                ]
            );

        $this->assertDatabaseHas('orders', $payload);
    }

    public function test_create_order_multiple_items_and_multiple_sellers()
    {
        $sellers = User::factory()->count(3)->create();
        $products = [];

        foreach ($sellers as $seller) {
            $products[] = Product::factory()->create(['seller_id' => $seller->id]);
        }


        $cart = Cart::instance('cart');

        foreach ($products as $key => $product) {
            $product->seller_id = $key;
            $cart->add(
                $product->id,
                $product->name,
                1,
                $product->regular_price
            )->associate(Product::class);
        }

        $address = Address::factory()->create();
        $deliveryMethod = DeliveryMethod::factory()->create(['country_id' => $address->country_id, 'name' => 'Large']);
        $cart->setShippingId($deliveryMethod->id);
        $expectedTotal = Cart::instance('cart')->total();

        SellerBalance::create(['balance' => 500, 'seller_id' => $this->seller->id, 'previous_balance' => 0]);

        $orderItems = $this->buildOrderItems($cart->content());

        $this->json('post', "api/orders", ['address_id' => $address->id, 'mode' => 'seller_balance'])
            ->assertStatus(200);

        $sellerTotal = collect($orderItems)->map(function (array $item) {
            return $item['discount'] > 0 ? $item['price'] * $item['quantity'] + $item['shipping_price'] - $item['discount'] : $item['price'] * $item['quantity'] + $item['shipping_price'];
        })->first();
        $sellerShippingPrice = collect($orderItems)->sum('shipping_price');

        foreach ($orderItems as $item) {
            $item['discount'] = null;
            $item['shipping_id'] = $deliveryMethod->id;
            $this->assertDatabaseHas('order_items', $item);
        }


        $this->assertDatabaseHas('seller_balance', ['balance' => 500 - $expectedTotal, 'seller_id' => $this->seller->id]);
        $this->assertDatabaseHas('seller_withdrawals', ['amount' => $expectedTotal, 'seller_id' => $this->seller->id]);
        $this->assertDatabaseHas('orders', ['customer_id' => $this->seller->id, 'address_id' => $address->id, 'total' => $expectedTotal, 'shipping' => $deliveryMethod->price * 3]);

        foreach ($orderItems as $product) {
            $sellerTotal = $product['price'] + $deliveryMethod->price;
            $this->assertDatabaseHas('transactions', ['seller_id' => $product['seller_id'], 'total' => $sellerTotal, 'shipping' => $deliveryMethod->price]);

        }

    }

    public function test_create_order_multiple_items()
    {
        $products = Product::factory()->count(3)->create(['seller_id' => $this->seller->id]);

        $cart = Cart::instance('cart');

        foreach ($products as $product) {
            $cart->add(
                $product->id,
                $product->name,
                1,
                $product->regular_price
            )->associate(Product::class);
        }

        $address = Address::factory()->create();
        $deliveryMethod = DeliveryMethod::factory()->create(['country_id' => $address->country_id, 'name' => 'Large']);
        $cart->setShippingId($deliveryMethod->id);
        $expectedTotal = Cart::instance('cart')->total();

        SellerBalance::create(['balance' => 500, 'seller_id' => $this->seller->id, 'previous_balance' => 0]);

        $orderItems = $this->buildOrderItems($cart->content());

        $this->json('post', "api/orders", ['address_id' => $address->id, 'mode' => 'seller_balance'])
            ->assertStatus(200);

        $sellerTotal = collect($orderItems)->map(function (array $item) {
            return $item['discount'] > 0 ? $item['price'] * $item['quantity'] + $item['shipping_price'] - $item['discount'] : $item['price'] * $item['quantity'] + $item['shipping_price'];
        })->first();
        $sellerShippingPrice = collect($orderItems)->sum('shipping_price');

        foreach ($orderItems as $item) {
            $item['discount'] = null;
            $item['shipping_id'] = $deliveryMethod->id;
            $this->assertDatabaseHas('order_items', $item);
        }


        $this->assertDatabaseHas('seller_balance', ['balance' => 500 - $expectedTotal, 'seller_id' => $this->seller->id]);
        $this->assertDatabaseHas('seller_withdrawals', ['amount' => $expectedTotal, 'seller_id' => $this->seller->id]);
        $this->assertDatabaseHas('orders', ['customer_id' => $this->seller->id, 'address_id' => $address->id, 'total' => $expectedTotal, 'shipping' => 10.99]);
        $this->assertDatabaseHas('transactions', ['seller_id' => $this->seller->id, 'total' => $sellerTotal, 'shipping' => $sellerShippingPrice]);
    }

    public function test_create_order_single_item()
    {
        $product = Product::factory()->create(['seller_id' => $this->seller->id]);

        $cart = Cart::instance('cart');

        $cart->add(
            $product->id,
            $product->name,
            1,
            $product->regular_price
        )->associate(Product::class);


        $address = Address::factory()->create();
        $deliveryMethod = DeliveryMethod::factory()->create(['country_id' => $address->country_id, 'name' => 'Large']);
        $cart->setShippingId($deliveryMethod->id);

        $commission = Cart::instance('cart')->commission();

        $orderItem = [
            'commission' => $commission,
            'id' => $product->id,
            'quantity' => 1,
            'discount' => null,
            'price' => $product->regular_price,
            'seller_id' => $product->seller_id,
            'shipping_id' => empty($deliveryMethod) ? null : $deliveryMethod->id,
            'shipping_price' => round($deliveryMethod->price, 4),
            'courier_id' => empty($deliveryMethod) ? null : $deliveryMethod->courier_id,
        ];

        SellerBalance::create(['balance' => 500, 'seller_id' => $this->seller->id, 'previous_balance' => 0]);

        $this->json('post', "api/orders", ['address_id' => $address->id, 'mode' => 'seller_balance'])
            ->assertStatus(200);

        $orderTotal = $product->regular_price + $deliveryMethod->price + $commission;

        $this->assertDatabaseHas('order_items', $orderItem);
        $this->assertDatabaseHas('seller_balance', ['balance' => 500 - $orderTotal, 'seller_id' => $this->seller->id]);
        $this->assertDatabaseHas('seller_withdrawals', ['amount' => $orderTotal, 'seller_id' => $this->seller->id]);
        $this->assertDatabaseHas('orders', ['customer_id' => $this->seller->id, 'address_id' => $address->id, 'total' => $orderTotal, 'shipping' => $deliveryMethod->price]);
        $this->assertDatabaseHas('transactions', ['seller_id' => $this->seller->id, 'total' => ($product->regular_price + $deliveryMethod->price), 'shipping' => $deliveryMethod->price]);
    }

    public function test_create_order_single_item_multiple_quantities()
    {
        $product = Product::factory()->create(['seller_id' => $this->seller->id]);

        $cart = Cart::instance('cart');

        $cart->add(
            $product->id,
            $product->name,
            3,
            $product->regular_price
        )->associate(Product::class);


        $address = Address::factory()->create();
        $deliveryMethod = DeliveryMethod::factory()->create(['country_id' => $address->country_id, 'name' => 'Large']);
        $cart->setShippingId($deliveryMethod->id);

        $commission = Cart::instance('cart')->commission();

        $orderItem = [
            'commission' => $commission,
            'id' => $product->id,
            'quantity' => 3,
            'discount' => null,
            'price' => $product->regular_price,
            'seller_id' => $product->seller_id,
            'shipping_id' => empty($deliveryMethod) ? null : $deliveryMethod->id,
            'shipping_price' => round($deliveryMethod->price, 4),
            'courier_id' => empty($deliveryMethod) ? null : $deliveryMethod->courier_id,
        ];

        SellerBalance::create(['balance' => 500, 'seller_id' => $this->seller->id, 'previous_balance' => 0]);

        $this->json('post', "api/orders", ['address_id' => $address->id, 'mode' => 'seller_balance'])
            ->assertStatus(200);

        $orderTotal = ($product->regular_price * 3) + $deliveryMethod->price + $commission;

        $this->assertDatabaseHas('order_items', $orderItem);
        $this->assertDatabaseHas('seller_balance', ['balance' => 500 - $orderTotal, 'seller_id' => $this->seller->id]);
        $this->assertDatabaseHas('seller_withdrawals', ['amount' => $orderTotal, 'seller_id' => $this->seller->id]);
        $this->assertDatabaseHas('orders', ['customer_id' => $this->seller->id, 'address_id' => $address->id, 'total' => $orderTotal, 'shipping' => $deliveryMethod->price]);
        $this->assertDatabaseHas('transactions', ['seller_id' => $this->seller->id, 'total' => (($product->regular_price * 3) + $deliveryMethod->price), 'shipping' => $deliveryMethod->price]);
    }

    private function buildOrderItems(Collection $items)
    {

        $orderItemData = [];

        $groupBySeller = [];
        $bulkPrice = config('shop.bulk_price');

        foreach ($items as $item) {
            if (!isset($groupBySeller[$item->model->seller_id])) {
                $groupBySeller[$item->model->seller_id] = 1;

                continue;
            }

            $groupBySeller[$item->model->seller_id]++;
        }

        $commission = Cart::instance('cart')->commission();

        foreach ($items as $item) {
            $deliveryMethod = $item->getDeliveryMethod();
            $shippingPrice = empty($deliveryMethod) || $item->hasBulk ? $bulkPrice / $groupBySeller[$item->model->seller_id] : $deliveryMethod->price;
            $itemCommission = $groupBySeller[$item->model->seller_id] > 1 ? $commission / $groupBySeller[$item->model->seller_id] : $commission;

            $item->setShippingPrice(round($shippingPrice, 4));

            $orderItemData[] = [
                'commission' => $itemCommission,
                'id' => $item->id,
                'quantity' => $item->qty,
                'discount' => 0,
                'price' => $item->price,
                'seller_id' => $item->model->seller_id,
                'shipping_id' => empty($deliveryMethod) ? null : $deliveryMethod->id,
                'shipping_price' => round($shippingPrice, 4),
                'courier_id' => empty($deliveryMethod) ? null : $deliveryMethod->courier_id,
            ];
        }

        return $orderItemData;
    }
}
