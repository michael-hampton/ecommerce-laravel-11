<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;
use App\Repositories\Interfaces\ITransactionRepository;

class SellerTransactionController extends ApiController
{
    public function __construct(private ITransactionRepository $transactionRepository)
    {

    }

    public function index()
    {
        $transactions = $this->transactionRepository->getAll(null, 'created_at', 'desc');

        return response()->json(TransactionResource::collection($transactions));
    }
}
