<?php

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
        private int                $sellerId,
        private float              $amount,
        private WithdrawalTypeEnum $type,
        private WithdrawalEnum     $withdrawalType,
        private int                $id
    )
    {

    }

    public function updateBalance()
    {
        $previousBalance = SellerBalance::where('seller_id', $this->sellerId)->orderByDesc('created_at')->first();

        $newBalance = $this->withdrawalType === WithdrawalEnum::Decrease ? $previousBalance->balance - $this->amount : $previousBalance->balance + $this->amount;

        if (empty($previousBalance) || $previousBalance->balance <= 0) {
            throw new Exception('Insufficient balance');
        }

        $withdrawalData = [
            'amount' => $this->amount,
            'seller_id' => $this->sellerId
        ];

        $data = [
            'seller_id' => auth()->id(),
            'balance' => $newBalance,
            'previous_balance' => $previousBalance->balance,
            'type' => $this->type->value
        ];

        if ($this->type === WithdrawalTypeEnum::OrderReceived) {
            $withdrawalData['transaction_id'] = $this->id;
            $data['transaction_id'] = $this->id;
        }

        if ($this->type === WithdrawalTypeEnum::OrderSpent) {
            $withdrawalData['order_id'] = $this->id;
            $data['order_id'] = $this->id;
        }

        SellerWithdrawal::create($withdrawalData);
        return SellerBalance::create($data);
    }
}


