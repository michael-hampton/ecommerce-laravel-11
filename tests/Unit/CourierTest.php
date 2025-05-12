<?php

namespace Tests\Feature;

use App\Models\Courier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CourierTest extends TestCase
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

        $this->json('post', 'api/couriers', $payload)
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
        $this->assertDatabaseMissing('couriers', ['name' => $payload['name']]);
    }

    public function test_get_all_couriers()
    {
        $this->json('get', 'api/couriers?page=1&limit=10&sortBy=name&sortDir=asc')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'name',
                    ],
                ]
            );
    }

    public function test_create_product_successful()
    {
        $payload = Courier::factory()->make()->toArray();

        $this->json('post', 'api/couriers', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'name',
                    ]
                ]
            );

        unset($payload['image']);
        $this->assertDatabaseHas('couriers', $payload);
    }

    public function testUserIsDestroyed()
    {
        $user = Courier::factory()->create();

        $this->json('delete', "api/couriers/$user->id")
            ->assertStatus(200);
        $this->assertDatabaseMissing('couriers', ['id' => $user->id]);
    }

    public function testUpdateUserReturnsCorrectData()
    {
        $user = Courier::factory()->create();

        $payload = Courier::factory()->make()->toArray();

        $this->json('put', "api/couriers/$user->id", $payload)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Courier updated',
                    'success' => true,
                    'data' => 1
                ]
            );

        $this->assertDatabaseHas('couriers', ['name' => $payload['name']]);
    }

    public function testUpdateActiveFlag()
    {
        $user = Courier::factory()->create()->toArray();

        $user['active'] = false;

        $this->json('delete', "api/couriers/{$user['id']}/active", $user)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Courier updated',
                    'success' => true,
                    'data' => true
                ]
            );

        $newRow = Courier::where('id', $user['id'])->first();

        $this->assertSame($newRow->active, false);
    }
}
