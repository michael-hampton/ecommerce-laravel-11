<?php



namespace App\Actions\Seller;

use App\Models\SellerBalance;
use App\Models\SellerWithdrawal;
use App\Models\Transaction;
use App\Repositories\Interfaces\ISellerRepository;

class WithdrawFunds
{
    public function __construct(private ISellerRepository $repository) {}

    /**
     * @return mixed
     */
    public function handle(array $data): ?SellerBalance
    {
        $sellerBalance = SellerBalance::where('seller_id', auth('sanctum')->id())->first();
        $affectedRows = SellerBalance::create([
            'balance' => $sellerBalance->balance - $data['amount'],
            'previous_balance' => $sellerBalance->balance,
            'transaction_id' => $data['transactionId'] ?? null,
            'seller_id' => auth('sanctum')->id(),
        ]);

        if (! empty($data['transactionId'])) {
            $transaction = Transaction::whereId($data['transactionId'])->first();
            $transaction->update(['withdrawn' => true]);
        }

        if (! empty($affectedRows)) {
            SellerWithdrawal::create([
                'amount' => $data['amount'],
                'seller_id' => auth('sanctum')->id(),
                'transaction_id' => $data['transactionId'] ?? null,
            ]);
        }

        return $sellerBalance->fresh();
    }
}
