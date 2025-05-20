<?php

namespace App\Services\PaymentProviders;

use App\Models\Transaction;
use Stripe\Account;
use Stripe\BankAccount;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Transfer;

interface PaymentProverInterface
{
    public function getBankAccount(int $sellerId, string $bankAccountId);
    public function updateCard(string $paymentMethodId, array $data): array;
    public function updateCustomer(int $sellerId, array $data): Customer;
    public function deleteCard(int $sellerId, string $paymentMethodId): PaymentMethod;
    public function capturePayment(Transaction $transaction): PaymentIntent;
    public function createBankAccount(array $data, int $sellerId): BankAccount;
    public function updateBankAccount(int $sellerId, string $bankAccountId, array $data): BankAccount;
    public function createAccount(array $data, int $sellerId): Account;
    public function attachPaymentMethodToCustomer(string $paymentMethodId, int $sellerId): PaymentMethod;
    public function createCustomer(array $data, int $sellerId): Customer;
    public function withdrawFromAccount(int $sellerId, float $amount, int $orderId): Charge;
    public function transferFundsToAccount(float $amount, int $sellerId): Transfer;
}
