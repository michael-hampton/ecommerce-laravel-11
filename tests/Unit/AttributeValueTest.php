<?php

namespace Tests\Feature;

use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AttributeValueTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create(), ['*']);
    }

    public function test_fails_validation()
    {
        $payload = ['name' => ''];

        $this->json('post', 'api/attribute-values', $payload)
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
        $this->assertDatabaseMissing('attribute_values', ['link' => 'http://www.bbc.co.uk']);
    }

    public function test_create_product_successful()
    {
        $payload = AttributeValue::factory()->make()->toArray();

        $this->json('post', 'api/attribute-values', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'name',
                        'attribute_id',
                    ]
                ]
            );

        unset($payload['image']);
        $this->assertDatabaseHas('attribute_values', $payload);
    }


    public function testUserIsDestroyed()
    {
       $user = AttributeValue::factory()->create();

        $this->json('delete', "api/attribute-values/$user->id")
            ->assertStatus(200);

        $this->assertSoftDeleted('attribute_values', ['id' => $user->id]);
    }

    public function testUpdateUserReturnsCorrectData()
    {
       $user = AttributeValue::factory()->create();

        $payload = AttributeValue::factory()->make()->toArray();

        $this->json('put', "api/attribute-values/$user->id", $payload)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Attribute Value updated',
                    'success' => true,
                    'data' => 1
                ]
            );

        $this->assertDatabaseHas('attribute_values', $payload);
    }

    public function test_get_all_attribute_values()
    {
        $this->json('get', 'api/attribute-values?page=1&limit=10&sortBy=name&sortDir=asc')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'attribute_id'
                        ],
                    ],
                ]
            )->assertJsonFragment(['current_page' => 1, 'per_page' => 10]);
    }
}
