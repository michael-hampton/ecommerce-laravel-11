<?php

namespace Tests\Unit;

use App\Http\Resources\ProductReviewResource;
use App\Http\Resources\SellerReviewResource;
use App\Models\Country;
use App\Models\NotificationType;
use App\Models\Profile;
use App\Models\SellerBalance;
use App\Models\SellerBankDetails;
use App\Models\SellerBillingInformation;
use App\Models\SellerWithdrawal;
use App\Models\User;
use Database\Seeders\NotificationTypes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SellerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->seller = User::factory()->create();
        Sanctum::actingAs($this->seller, ['*']);

        $this->country = Country::create([
            'name' => 'Afghanistan',
            'code' => 'UK'
        ]);

        $this->user = User::factory()->create();
        $this->review = $this->seller->reviews()->create(['comment' => $this->faker->sentence(), 'rating' => 5, 'user_id' => $this->user->id]);

    }

    public function test_update_profile()
    {
        $user = Profile::factory()->create();

        $payload = Profile::factory()->make()->toArray();

        $this->json('put', "api/sellers/$user->id", $payload)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'Seller updated',
                    'success' => true,
                    'data' => true
                ]
            );

        $this->assertDatabaseHas('profiles', $payload);
    }

    public function test_save_billing()
    {
        $payload = SellerBillingInformation::factory()->make(['seller_id' => $this->seller->id])->toArray();

        $this->json('post', "api/sellers/billing", $payload)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'billing details updated',
                    'success' => true,
                    'data' => SellerBillingInformation::first()->toArray()
                ]
            );

        $this->assertDatabaseHas('seller_billing_information', $payload);

        //Test Update
        $payload = SellerBillingInformation::factory()->make(['seller_id' => $this->seller->id])->toArray();

        $this->json('post', "api/sellers/billing", $payload)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'message' => 'billing details updated',
                    'success' => true,
                    'data' => SellerBillingInformation::first()->toArray()
                ]
            );

        $this->assertDatabaseHas('seller_billing_information', $payload);
    }

    public function test_review()
    {
        $payload = [
            'reply' => $this->faker->paragraph(2),
            'reviewId' => $this->review->id
        ];

        $this->json('post', "api/reviews/reply", $payload)
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'message' => 'Reply was created',
                    'success' => true,
                ]
            );


        $this->assertDatabaseHas('reviews', ['comment' => $payload['reply'], 'commentable_id' => $this->seller->id, 'commentable_type' => User::class]);
    }

    public function test_review_fails_validation()
    {
        $payload = [
            'reply' => '',
            'reviewId' => $this->review->id
        ];

        $this->json('post', 'api/reviews/reply', $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    'success' => false,
                    'message' => "Validation failed.",
                    'errors' => [
                        'reply' => [
                            'The reply field is required.'
                        ]
                    ]
                ]
            );
    }

    public function test_create_bank_details()
    {
        $payload = [
            'account_name' => $this->faker->name(),
            'account_number' => $this->faker->randomNumber(),
            'bank_name' => 'Halifax',
        ];

        $response = $this->json('post', "api/sellers/account/bank", $payload)
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'message' => 'bank details updated',
                    'success' => true,
                ]
            );


        $this->assertDatabaseHas('seller_bank_details', $payload);

        // update
        $payload = [
            'account_name' => $this->faker->name(),
            'account_number' => $this->faker->randomNumber(),
            'bank_name' => 'Halifax',
        ];

        $bankAccount = SellerBankDetails::first();

        $response = $this->json('post', "api/sellers/account/bank", $payload)
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'message' => 'bank details updated',
                    'success' => true,
                ]
            );


        $this->assertDatabaseHas('seller_bank_details', $payload);
        $this->assertSame(1, SellerBankDetails::count());
    }

    public function test_bank_account_validation_fails()
    {
        $payload = [
            'account_name' => '',
            'account_number' => '',
            'bank_name' => '',
        ];

        $response = $this->json('post', "api/sellers/account/bank", $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    'success' => false,
                    'message' => "Validation failed.",
                    'errors' => [
                        'bank_name' => [
                            'The bank name field is required.'
                        ],
                        'account_name' => [
                            'The account name field is required.'
                        ],
                        'account_number' => [
                            'The account number field is required.'
                        ]
                    ]
                ]
            );
    }

    public function test_create_card_details()
    {
        $payload = [
            'card_name' => $this->faker->name(),
            'card_number' => $this->faker->creditCardNumber(),
            'card_expiry_date' => $this->faker->creditCardExpirationDateString(),
            'card_cvv' => '123',
        ];

        $response = $this->json('post', "api/sellers/account/card", $payload)
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'message' => 'Card Created',
                    'success' => true,
                ]
            );

        $this->assertDatabaseHas('seller_bank_details', $payload);
    }

    public function test_update_card_details()
    {
        $card = SellerBankDetails::factory()->create(['seller_id' => $this->seller->id]);

        $payload = SellerBankDetails::factory()->make(['seller_id' => $this->seller->id])->toArray();

        $response = $this->json('put', "api/sellers/account/card/$card->id", $payload)
            ->assertStatus(200)
            ->assertJsonFragment(
                [
                    'message' => 'Card Updated',
                    'success' => true,
                ]
            );

        $this->assertDatabaseHas('seller_bank_details', $payload);
    }

    public function test_credit_card_validation_fails()
    {
        $payload = [
            'card_name' => '',
            'card_number' => '',
            'card_expiry_date' => '',
            'card_cvv' => '',
        ];

        $response = $this->json('post', "api/sellers/account/card", $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    'success' => false,
                    'message' => "Validation failed.",
                    'errors' => [
                        'card_name' => [
                            'The card name field is required.'
                        ],
                        'card_number' => [
                            'The card number field is required.'
                        ],
                        'card_expiry_date' => [
                            'The card expiry date field is required.'
                        ]
                    ]
                ]
            );
    }

    public function test_credit_card_deleted()
    {

        $user = SellerBankDetails::factory()->create();

        $this->json('delete', "api/sellers/account/card/$user->id")
            ->assertStatus(200);
        $this->assertDatabaseMissing('seller_bank_details', ['id' => $user->id]);
    }

    public function test_bank_account_deleted()
    {

        $payload = [
            'account_name' => $this->faker->name(),
            'account_number' => $this->faker->randomNumber(),
            'bank_name' => 'Halifax',
            'type' => 'bank',
            'seller_id' => $this->seller->id
        ];
        $user = SellerBankDetails::create(
            $payload
        );

        $this->json('delete', "api/sellers/account/bank/$user->id")
            ->assertStatus(200);
        $this->assertDatabaseMissing('seller_bank_details', $payload);
    }

    public function test_withdrawal()
    {
        $data = ['seller_id' => $this->seller->id, 'balance' => 100, 'previous_balance' => 0];
        SellerBalance::create($data);

        $payload = [
            'amount' => 20,
        ];

        $response = $this->json('post', "api/sellers/account/balance/withdraw", $payload)
            ->assertStatus(200)
            ->assertJson(
                ['balance' => 80, 'previous_balance' => 100]
            );

        $this->assertDatabaseHas('seller_balance', ['balance' => 80, 'previous_balance' => 100, 'seller_id' => $this->seller->id]);

        $this->assertDatabaseHas('seller_withdrawals', ['amount' => 20, 'seller_id' => $this->seller->id]);
    }

    public function test_withdrawal_validation_fails()
    {
        $payload = [
            'amount' => '',
        ];

        $response = $this->json('post', "api/sellers/account/balance/withdraw", $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    'success' => false,
                    'message' => "Validation failed.",
                    'errors' => [
                        'amount' => [
                            'The amount field is required.'
                        ],
                    ]
                ]
            );
    }

    public function test_get_all_sellers()
    {
        $this->json('get', 'api/sellers?page=1&limit=10&sortBy=name&sortDir=asc')
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

    public function test_save_notifications()
    {

        $this->seed(class: NotificationTypes::class);

        $payload = [
            'notification_types' => [
                1 => true,
                2 => true,
                3 => true,
                4 => true,
            ],
        ];

        $response = $this->json('post', "api/notifications", $payload)
            ->assertStatus(200)
            ->assertJson(
                [
                    'success' => true,
                    'message' => "notification saved successfully",
                ]
            );
    }
}
