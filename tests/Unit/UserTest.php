<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
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
            'image' => UploadedFile::fake()->image('file1.png', 600, 600),
        ];

        $this->json('post', 'api/users', $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    'success' => false,
                    'message' => "Validation failed.",
                    'errors' => [
                        'name' => [
                            'The name field is required.'
                        ],
                        'email' => [
                            'The email field is required.'
                        ],
                        'password' => [
                            'The password field is required.'
                        ]
                    ]
                ]
            );
        $this->assertDatabaseMissing('users', ['link' => 'http://www.bbc.co.uk']);
    }

    public function test_create_product_successful()
    {
        $password = $this->faker->password();
        $payload = User::factory()->make()->toArray();
        $payload['password'] = $password;
        $payload['password_confirmation'] = $password;

        $this->json('post', 'api/users', $payload)
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

        unset($payload['image'], $payload['password_confirmation'], $payload['password']);

        $this->assertDatabaseHas('users', $payload);
    }

    public function testUserIsDestroyed()
    {
        $user = User::factory()->create();

        $this->json('delete', "api/users/$user->id")
            ->assertStatus(200);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function testUpdateUserReturnsCorrectData()
    {
        $user = User::factory()->create();
        $payload = User::factory()->make()->toArray();

        $this->json('put', "api/users/$user->id", $payload)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'User updated',
                    'success' => true,
                    'data' => 1
                ]
            );

        unset($payload['image']);

        $this->assertDatabaseHas('users', $payload);
    }

    public function test_get_all_users()
    {
        $this->json('get', 'api/users?page=1&limit=10&sortBy=name&sortDir=asc')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'mobile',
                            'email',
                            'image'
                        ],
                    ],
                ]
            )->assertJsonFragment(['current_page' => 1, 'per_page' => 10]);
    }

    public function testUpdateActiveFlag()
    {
        $user = User::factory()->create()->toArray();

        $user['active'] = false;

        $this->json('delete', "api/users/{$user['id']}/active", $user)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'User updated',
                    'success' => true,
                    'data' => true
                ]
            );

        $newRow = User::where('id', $user['id'])->first();

        $this->assertSame($newRow->active, false);
    }
}
