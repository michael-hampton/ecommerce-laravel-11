<?php

namespace Tests\Feature;

use App\Services\PaymentProviders\PayMongo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PayMongoTest extends TestCase
{
    public function test_payment_intent() {
        (new PayMongo())->createPaymentIntent(['amount' => 500, 'first_name' => 'Michael', 'last_name'=> 'Hampton', 'phone' => '+447851624051', 'email' => 'michaelhamptondesign@yahoo.com']);
    }

    // public function test_create_customer()
    // {
    //     (new PayMongo())->createCustomer(['first_name' => 'Michael', 'last_name' => 'Hampton', 'phone' => '+447851624051', 'email' => 'michaelhamptondesign@yahoo.com']);
    // }
}
