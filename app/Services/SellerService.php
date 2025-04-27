<?php

namespace App\Services;

use App\Models\SellerBalance;
use App\Models\SellerWithdrawal;
use App\Models\Transaction;
use App\Repositories\Interfaces\ISellerRepository;
use App\Services\Interfaces\ISellerService;

class SellerService implements ISellerService
{
    public function __construct(private ISellerRepository $repository)
    {

    }
    public function createSeller(array $data) {
        return $this->repository->create($data);
    }

    public function updateSeller(array $data, int $id) {
        return $this->repository->update($id, $data);
    }

    public function deleteSeller(int $id) {
        return $this->repository->delete($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function withdrawFunds(array $data) {
        $sellerBalance = SellerBalance::where('seller_id', auth('sanctum')->id())->first();
        $affectedRows = SellerBalance::create([
            'balance' => $sellerBalance->balance - $data['amount'],
            'previous_balance' => $sellerBalance->balance,
            'transaction_id' => $data['transactionId'] ?? null,
            'seller_id' => auth('sanctum')->id(),
        ]);

        if(!empty($data['transactionId'])) {
            $transaction = Transaction::whereId($data['transactionId'])->first();
            $transaction->update(['withdrawn' => true]);
        }

        if (!empty($affectedRows)) {
            SellerWithdrawal::create([
                'amount' => $data['amount'],
                'seller_id' => auth('sanctum')->id(),
                'transaction_id' => $data['transactionId'] ?? null,
            ]);
        }

        return $sellerBalance->fresh();
    }
}
