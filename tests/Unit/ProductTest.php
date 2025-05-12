<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
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
        $payload = [
            'name' => '',
            'image' => UploadedFile::fake()->image('file1.png', 600, 600)
        ];

        $this->json('post', 'api/products', $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    'success' => false,
                    'message' => "Validation failed.",
                    'errors' => [
                        'name' => [
                            'The name field is required.'
                        ],
                        'slug' => [
                            'The slug field is required.'
                        ],
                        'category_id' => [
                            'The category id field is required.'
                        ],
                        'brand_id' => [
                            'The brand id field is required.'
                        ],
                        'short_description' => [
                            'The short description field is required.'
                        ],
                        'description' => [
                            'The description field is required.'
                        ],
                        'regular_price' => [
                            'The regular price field is required.'
                        ],
                        // 'sale_price' => [
                        //     'The sale price field is required.'
                        // ],
                        // 'SKU' => [
                        //     'The SKU field is required.'
                        // ],
                        'stock_status' => [
                            'The stock status field is required.'
                        ]
                    ]
                ]
            );
        $this->assertDatabaseMissing('products', ['link' => 'http://www.bbc.co.uk']);
    }

    public function test_create_product_successful()
    {
        $payload = Product::factory()->make(['seller_id' => $this->seller->id])->toArray();

        $this->json('post', 'api/products', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'name',
                        'image'
                    ]
                ]
            );

        unset($payload['image'], $payload['images']);
        $this->assertDatabaseHas('products', $payload);
    }

    public function testUserIsDestroyed()
    {
        $user = Product::factory()->create();

        $this->json('delete', "api/products/$user->id")
            ->assertStatus(200);
        $this->assertSoftDeleted('products', ['id' => $user->id]);
    }

    public function testUpdateUserReturnsCorrectData()
    {
        $user = Product::factory()->create();
        $payload = Product::factory()->make()->toArray();

        $this->json('put', "api/products/$user->id", $payload)
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'message' => 'Product updated',
                    'success' => true,
                ]
            );

        $this->assertDatabaseHas('products', ['name' => $payload['name']]);
    }

    public function test_get_all_products()
    {
        $this->json('get', 'api/products?page=1&limit=10&sortBy=name&sortDir=asc')
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

    public function testUpdateActiveFlag()
    {
        $user = Product::factory()->create()->toArray();

        $user['active'] = false;

        $this->json('delete', "api/products/{$user['id']}/active", $user)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Product updated',
                    'success' => true,
                    'data' => true
                ]
            );

        $newRow = Product::where('id', $user['id'])->first();

        $this->assertSame($newRow->active, false);
    }
}
