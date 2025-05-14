<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SellerBalance;
use App\Models\SellerWithdrawal;
use App\Models\WithdrawalEnum;
use App\Models\WithdrawalTypeEnum;
use App\Services\Interfaces\IWithdrawalService;
use Exception;

class WithdrawalService implements IWithdrawalService
{
    public function __construct(
        private readonly int $sellerId,
        private readonly float $amount,
        private readonly WithdrawalTypeEnum $withdrawalTypeEnum,
        private readonly WithdrawalEnum $withdrawalEnum,
        private readonly ?int $id
    ) {
    }

    public function updateBalance()
    {
        $previousBalance = SellerBalance::where('seller_id', $this->sellerId)->orderByDesc('created_at')->first();

        $newBalance = (empty($previousBalance)) ? $this->amount : (($this->withdrawalEnum === WithdrawalEnum::Decrease) ? $previousBalance->balance - $this->amount : $previousBalance->balance + $this->amount);

        if (empty($previousBalance) || $previousBalance->balance <= 0) {
            throw new Exception('Insufficient balance');
        }

        $withdrawalData = [
            'amount' => $this->amount,
            'seller_id' => $this->sellerId,
        ];

        $data = [
            'seller_id' => auth()->id(),
            'balance' => $newBalance,
            'previous_balance' => $previousBalance->balance,
            'type' => $this->withdrawalTypeEnum->value,
        ];

        if ($this->withdrawalTypeEnum === WithdrawalTypeEnum::OrderReceived) {
            $withdrawalData['transaction_id'] = $this->id;
            $data['transaction_id'] = $this->id;
        }

        if ($this->withdrawalTypeEnum === WithdrawalTypeEnum::BumpProduct) {
            $withdrawalData['product_id'] = $this->id;
            $data['product_id'] = $this->id;
        }

        if ($this->withdrawalTypeEnum === WithdrawalTypeEnum::OrderSpent) {
            $withdrawalData['order_id'] = $this->id;
            $data['order_id'] = $this->id;
        }

        //SellerWithdrawal::create($withdrawalData);

        return SellerBalance::create($data);
    }
}
