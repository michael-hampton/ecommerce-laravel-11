<?php

namespace Tests\Feature;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CouponTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create(), ['*']);
    }

    public function test_fails_validation()
    {
        $payload = [
            'cart_value' => $this->faker->numberBetween(1, 100),
        ];

        $this->json('post', 'api/coupons', $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    'success' => false,
                    'message' => "Validation failed.",
                    'errors' => [
                        'code' => [
                            'The code field is required.'
                        ],
                        'type' => [
                            'The type field is required.'
                        ],
                        'value' => [
                            'The value field is required.'
                        ],
                        'expires_at' => [
                            'The expires at field is required.'
                        ],
                    ]
                ]
            );
        $this->assertDatabaseMissing('coupons', ['link' => 'http://www.bbc.co.uk']);
    }

    public function test_create_product_successful()
    {
        $payload = Coupon::factory()->make()->toArray();

        $this->json('post', 'api/coupons', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'code',
                        'cart_value',
                        'type',
                        'expires_at',
                        'value'
                    ]
                ]
            );

        unset($payload['image']);
        $this->assertDatabaseHas('coupons', $payload);
    }

    public function testUserIsDestroyed()
    {
        $user = Coupon::factory()->create();

        $this->json('delete', "api/coupons/$user->id")
            ->assertStatus(200);
       $this->assertDatabaseMissing('coupons', ['id' => $user->id]);
    }

    public function testUpdateUserReturnsCorrectData()
    {
        $user = Coupon::factory()->create();

        $payload = Coupon::factory()->make()->toArray();

        $this->json('put', "api/coupons/$user->id", $payload)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Coupon updated',
                    'success' => true,
                    'data' => 1
                ]
            );
    }

    public function test_get_all_coupons()
    {
        $this->json('get', 'api/coupons?page=1&limit=10&sortBy=name&sortDir=asc')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'code',
                            'type',
                            'cart_value',
                            'value',
                            'expires_at'
                        ],
                    ],
                ]
            )->assertJsonFragment(['current_page' => 1, 'per_page' => 10]);
    }
}
