<?php

declare(strict_types=1);

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
        $builder = $this->getQuery();

        $builder->when(! empty($searchParams['seller_id']), function (Builder $builder) use ($searchParams): void {
            $builder->where('seller_id', $searchParams['seller_id']);
        });

        return $builder;
    }
}
