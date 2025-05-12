<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
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
            'slug' => $this->faker->slug(),
        ];

        $this->json('post', 'api/categories', $payload)
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
        $this->assertDatabaseMissing('categories', ['slug' => $payload['slug']]);
    }

    public function test_get_all_categories()
    {
        $this->json('get', 'api/categories?page=1&limit=10&sortBy=name&sortDir=asc')
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

    public function test_create_product_successful()
    {
        $payload = Category::factory()->make()->toArray();

        $this->json('post', 'api/categories', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'name',
                        'slug',
                        'image'
                    ]
                ]
            );

        unset($payload['image']);
        $this->assertDatabaseHas('categories', $payload);
    }

    public function testUserIsDestroyed()
    {
        $user = Category::factory()->create();

        $this->json('delete', "api/categories/$user->id")
            ->assertStatus(200);
        $this->assertSoftDeleted('categories', ['id' => $user->id]);
    }

    public function testUpdateUserReturnsCorrectData()
    {
        $user = Category::factory()->create();

        $payload = Category::factory()->make()->toArray();

        $this->json('put', "api/categories/$user->id", $payload)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Category updated',
                    'success' => true,
                    'data' => 1
                ]
            );

        unset($payload['image']);
        $this->assertDatabaseHas('categories', $payload);
    }

    public function testUpdateActiveFlag()
    {
        $user = Category::factory()->create()->toArray();

        $user['active'] = false;

        $this->json('delete', "api/categories/{$user['id']}/active", $user)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Category updated',
                    'success' => true,
                    'data' => true
                ]
            );

        $newRow = Category::where('id', $user['id'])->first();

        $this->assertSame($newRow->active, false);
    }
}
