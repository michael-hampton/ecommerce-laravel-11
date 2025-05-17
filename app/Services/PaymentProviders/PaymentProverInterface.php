<?php

namespace App\Services\PaymentProviders;

interface PaymentProverInterface
{
    public function getBankAccount(int $sellerId, string $bankAccountId);
    public function updateCard(string $paymentMethodId, array $data): PaymentMethod;
    public function updateCustomer(int $sellerId, array $data): Customer;
    public function deleteCard(int $sellerId, string $paymentMethodId): PaymentMethod;
    public function capturePayment(Transaction $transaction): Charge;
    public function createBankAccount(array $data, int $sellerId): BankAccount;
    public function updateBankAccount(int $sellerId, string $bankAccountId, array $data): BankAccount;
    public function createAccount(array $data, int $sellerId): Account;
    public function attachPaymentMethodToCustomer(string $paymentMethodId, int $sellerId): PaymentMethod;
    public function createCustomer(array $data, int $sellerId): Customer;
}
