<?php

namespace App\Services\PaymentProviders;

class PaymentProviderFactory
{

    private $providers = [
        'stripe' => Stripe::class,
    ];


    public function getClass() {
       $provider = $this->providers[\config('shop.payment_provider')];

       return new $provider();
    }
}
