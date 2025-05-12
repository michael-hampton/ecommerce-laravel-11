<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Courier;
use App\Models\DeliveryMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeliveryMethodTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create(), ['*']);

        $this->courier = Courier::factory()->create();

        $this->country = Country::factory()->create();
    }

    public function test_fails_validation()
    {
        $payload = [
            ['name' => $this->faker->name],
        ];

        $this->json('post', 'api/delivery-methods', ['methods' => json_encode($payload)])
            ->assertStatus(422)
            ->assertJson(
                [
                    'success' => false,
                    'message' => "Validation failed.",
                    'errors' => [
                        'country_id' => [
                            0 => 'The country id field is required.'
                        ],
                        // 'price' => [
                        //     0 => 'The price field is required.'
                        // ]
                    ]
                ]
            );
    }

    public function test_create_product_successful()
    {

        $payload =  DeliveryMethod::factory()->count(3)->make()->toArray();

        $this->json('post', 'api/delivery-methods', ['methods' => json_encode($payload), 'country_id' => $this->country->id])
            ->assertStatus(200)->assertJsonFragment(['success' => true]);
        $this->assertDatabaseHas('delivery_methods', $payload[0]);
    }

    public function testUserIsDestroyed()
    {

        $payload = DeliveryMethod::factory()->count(3)->create()->toArray();

        $test = array_splice($payload, 1, 1);
        unset($payload[1]);

        $this->json('put', "api/delivery-methods/1", ['methods' => json_encode($payload), 'country_id' => $this->country->id])
            ->assertStatus(200);

        $this->assertDatabaseMissing('delivery_methods', $test[0]);
    }

    public function testUpdateUserReturnsCorrectData()
    {
        $payload = DeliveryMethod::factory()->count(3)->create()->toArray();

        $test = $payload[1];
        $test['price'] = 11.99;

        $this->json('put', "api/delivery-methods/1", ['methods' => json_encode([$test]), 'country_id' => $test['country_id']])
            ->assertStatus(200);

        $this->assertDatabaseHas('delivery_methods', $test);
    }

    public function test_get_all_delivery_methods()
    {
        $this->json('get', 'api/delivery-methods?page=1&limit=10&sortBy=name&sortDir=asc')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'code',
                            'name',
                        ],
                    ],
                ]
            )->assertJsonFragment(['current_page' => 1, 'per_page' => 10]);
    }
}
