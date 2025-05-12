<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BrandTest extends TestCase
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

        $this->json('post', 'api/brands', $payload)
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
        $this->assertDatabaseMissing('brands', ['slug' => $payload['slug']]);
    }

    public function test_get_all_brands()
    {
        $this->json('get', 'api/brands?page=1&limit=10&sortBy=name&sortDir=asc')
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
        $payload = Brand::factory()->make()->toArray();

        $this->json('post', 'api/brands', $payload)
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
        $this->assertDatabaseHas('brands', $payload);
    }

    public function testUserIsDestroyed()
    {
        $user = Brand::factory()->create();

        $this->json('delete', "api/brands/$user->id")
            ->assertStatus(200);
        $this->assertSoftDeleted('brands', ['id' => $user->id]);
    }

    public function testUpdateUserReturnsCorrectData()
    {
        $user = Brand::factory()->create();

        $payload = Brand::factory()->make()->toArray();

        $this->json('put', "api/brands/$user->id", $payload)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Brand updated',
                    'success' => true,
                    'data' => 1
                ]
            );

        $this->assertDatabaseHas('brands', ['name' => $payload['name']]);
    }

    public function testUpdateActiveFlag()
    {
        $user = Brand::factory()->create()->toArray();

        $user['active'] = false;

        $this->json('delete', "api/brands/{$user['id']}/active", $user)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Brand updated',
                    'success' => true,
                    'data' => true
                ]
            );

        $newRow = Brand::where('id', $user['id'])->first();

        $this->assertSame($newRow->active, false);
    }
}
