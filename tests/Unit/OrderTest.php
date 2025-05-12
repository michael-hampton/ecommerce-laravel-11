<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Country;
use App\Models\Courier;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create(), ['*']);
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
}
