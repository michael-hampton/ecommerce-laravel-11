<?php

namespace Tests\Feature;

use App\Models\Slide;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SlideTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create(), ['*']);
    }

    public function test_fails_validation()
    {
        $payload = Slide::factory()->make(['title' => ''])->toArray();

        $this->json('post', 'api/slides', $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    'success' => false,
                    'message' => "Validation failed.",
                    'errors' => [
                        'title' => [
                            'The title field is required.'
                        ]
                    ]
                ]
            );
        $this->assertDatabaseMissing('slides', ['link' => 'http://www.bbc.co.uk']);
    }

    public function test_create_product_successful()
    {
        $payload = Slide::factory()->make()->toArray();

        $this->json('post', 'api/slides', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'tags',
                        'title',
                        'subtitle',
                        'created_at',
                        'link',
                        'image'
                    ]
                ]
            );

        unset($payload['image']);
        $this->assertDatabaseHas('slides', $payload);
    }

    public function testUserIsDestroyed()
    {
        $user = Slide::factory()->create();

        $this->json('delete', "api/slides/$user->id")
            ->assertStatus(200);
        $this->assertDatabaseMissing('slides', ['id' => $user->id]);
    }

    public function testUpdateUserReturnsCorrectData()
    {
        $user = Slide::factory()->create();

        $payload = Slide::factory()->make()->toArray();

        $this->json('put', "api/slides/$user->id", $payload)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Slide updated',
                    'success' => true,
                    'data' => 1
                ]
            );

        unset($payload['image']);

        $this->assertDatabaseHas('slides', $payload);
    }

    public function test_get_all_slides()
    {
        $this->json('get', 'api/slides?page=1&limit=10&sortBy=name&sortDir=asc')
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
        $user = Slide::factory()->create()->toArray();

        $user['active'] = false;

        $this->json('delete', "api/slides/{$user['id']}/active", $user)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Slide updated',
                    'success' => true,
                    'data' => true
                ]
            );

        $newRow = Slide::where('id', $user['id'])->first();

        $this->assertSame($newRow->active, false);
    }
}
