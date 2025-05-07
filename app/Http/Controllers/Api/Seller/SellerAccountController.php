<?php

namespace App\Http\Controllers\Api\Seller;

use App\Actions\Seller\CreateCard;
use App\Actions\Seller\DeleteBankAccount;
use App\Actions\Seller\RemoveCard;
use App\Actions\Seller\SaveBankAccount;
use App\Actions\Seller\UpdateCard;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSellerBankDetails;
use App\Http\Requests\UpdateSellerCardDetails;
use App\Http\Resources\CardDetailsResource;
use App\Models\SellerBankDetails;
use Illuminate\Http\Request;

class SellerAccountController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return response()->json(CardDetailsResource::collection(SellerBankDetails::where('seller_id', auth('sanctum')->user()->id)
            ->where('type', 'card')
            ->get()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateSellerCardDetails $request, CreateCard $createCard)
    {
        $result = $createCard->handle($request);

        return $result ? $this->success(CardDetailsResource::make($result), 'Card Created') : $this->error($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, UpdateCard $updateCard)
    {
        $result = $updateCard->handle($request);

        return $result ? $this->success(CardDetailsResource::make($result), 'Card Updated') : $this->error($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, RemoveCard $removeCard)
    {
        $result = $removeCard->handle($id);

        return $result ? $this->success($result, 'Card Removed') : $this->error('Unable to remove card');
    }

    public function getSellerBankAccountDetails()
    {
        return response()->json(
            SellerBankDetails::where('seller_id', auth('sanctum')->user()->id)
                ->where('type', 'bank')
                ->first()
        );
    }

    public function deleteBankAccount(int $id, DeleteBankAccount $deleteBankAccount)
    {
        $result = $deleteBankAccount->handle($id);
        return $result ? $this->success($result, 'Bank Account Removed') : $this->error('Unable to remove bank account');
    }

    public function saveBankDetails(UpdateSellerBankDetails $request, SaveBankAccount $saveBankAccount)
    {
        $result = $saveBankAccount->handle($request);

        if (!$result) {
            return $this->error('Unable to save bank details');
        }

        return $this->success($result, 'bank details updated');
    }

}
