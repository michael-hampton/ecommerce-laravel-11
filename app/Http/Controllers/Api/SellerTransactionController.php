<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Repositories\Interfaces\ITransactionRepository;

class SellerTransactionController extends ApiController
{
    public function __construct(private ITransactionRepository $transactionRepository)
    {

    }

    public function getSellerTransactions()
    {
        $transactions = $this->transactionRepository->getAll(null, 'created_at', 'desc');

        return response()->json(TransactionResource::collection($transactions));
    }
}
