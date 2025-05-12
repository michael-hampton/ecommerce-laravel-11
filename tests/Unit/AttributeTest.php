<?php

namespace Tests\Feature;

use App\Models\ProductAttribute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AttributeTest extends TestCase
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
            'name' => '',
        ];

        $this->json('post', 'api/attributes', $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    'success' => false,
                    'message' => "Validation failed.",
                    'errors' => [
                        'name' => [
                            'The name field is required.'
                        ]
                    ]
                ]
            );
        $this->assertDatabaseMissing('product_attributes', ['link' => 'http://www.bbc.co.uk']);
    }

    public function test_create_product_successful()
    {
        $payload = ProductAttribute::factory()->make()->toArray();

        $this->json('post', 'api/attributes', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'name',
                    ]
                ]
            );

        $this->assertDatabaseHas('product_attributes', $payload);
    }

    public function testUserIsDestroyed()
    {
        $user = ProductAttribute::factory()->create();

        $this->json('delete', "api/attributes/$user->id")
            ->assertStatus(200);
        $this->assertSoftDeleted('product_attributes', ['id' => $user->id]);
    }

    public function testUpdateUserReturnsCorrectData()
    {
        $user = ProductAttribute::factory()->create();

        $payload = ProductAttribute::factory()->make()->toArray();

        $this->json('put', "api/attributes/$user->id", $payload)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Attribute updated',
                    'success' => true,
                    'data' => 1
                ]
            );

        $this->assertDatabaseHas('product_attributes', $payload);
    }

    public function test_get_all_attributes()
    {
        $this->json('get', 'api/attributes?page=1&limit=10&sortBy=name&sortDir=asc')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                        ],
                    ],
                ]
            )->assertJsonFragment(['current_page' => 1, 'per_page' => 10]);
    }
}
