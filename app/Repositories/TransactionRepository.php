<?php



namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Interfaces\ITransactionRepository;
use Illuminate\Database\Eloquent\Builder;

class TransactionRepository extends BaseRepository implements ITransactionRepository
{
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $query = $this->getQuery();

        $query->when(! empty($searchParams['seller_id']), function (Builder $query) use ($searchParams) {
            $query->where('seller_id', $searchParams['seller_id']);
        });

        return $query;
    }
}
