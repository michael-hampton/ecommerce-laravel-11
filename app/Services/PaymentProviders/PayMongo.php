<?php

namespace App\Services\PaymentProviders;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class PayMongo
{

    public function createPaymentIntent(array $data)
    {
        $customer = $this->getCustomer($data['email']);

        //$customer = $this->createCustomer($data);

        $body = [
            'data' => [
                'attributes' => [
                    'amount' => $data['amount'] * 100,
                    'payment_method_allowed' => ['qrph', 'card', 'dob', 'paymaya', 'billease', 'gcash', 'grab_pay'],
                    'currency' => 'PHP',
                    'capture_type' => 'manual',
                    'setup_future_usage' => [
                        'session_type' => 'on_session',
                        'customer_id' => $customer['data'][0]['id']
                    ],
                ]
            ]
        ];

        $response = Http::withBasicAuth(config('services.paymongo.api_key'), '')->post('https://api.paymongo.com/v1/payment_intents', $body);

        if ($response->successful()) {
            $body = $response->json();
            echo '<pre>';
            print_r($body);

            echo $body['data']['id'];
            die;

            return $body['data']['id'];
        }

        echo '<pre>';
        print_r($response->json());
        die;


        //handle error
    }

    public function capturePayment()
    {
        $data = [
            'data' => [
                'attributes' => [
                    'amount' => 0
                ]
            ]
        ];

        $response = Http::withBasicAuth(config('services.paymongo.api_key'), '')->post('https://api.paymongo.com/v1/payment_intents/id/capture', $data);

    }

    public function createCustomer(array $data)
    {
        //cus_XR3FPp2dbyTgfaQcb1GEaMCE
        $body = [
            'data' => [
                'attributes' => [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'default_device' => 'email'
                ]
            ]
        ];

        $response = Http::withBasicAuth(config('services.paymongo.secret_key'), '')->post('https://api.paymongo.com/v1/customers', $body);

        if ($response->successful()) {
            $body = $response->json();

            return $body['data']['id'];
        }

        echo '<pre>';
        print_r($response->json());
        die;

        return false;
    }

    public function getCustomer(string $emailAddress)
    {
        return Http::withBasicAuth(config('services.paymongo.secret_key'), '')->get('https://api.paymongo.com/v1/customers?email=' . $emailAddress)->json();
    }
}
