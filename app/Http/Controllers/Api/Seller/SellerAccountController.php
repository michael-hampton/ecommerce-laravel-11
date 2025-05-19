<?php



namespace App\Http\Controllers\Api\Seller;

use App;
use App\Actions\Seller\CreateCard;
use App\Actions\Seller\DeleteBankAccount;
use App\Actions\Seller\RemoveCard;
use App\Actions\Seller\SaveBankAccount;
use App\Actions\Seller\UpdateCard;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\UpdateSellerBankDetails;
use App\Http\Requests\UpdateSellerCardDetails;
use App\Http\Resources\CardDetailsResource;
use App\Models\SellerBankDetails;
use App\Services\PaymentProviders\PaymentProviderFactory;
use Illuminate\Http\Request;

class SellerAccountController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = (new PaymentProviderFactory())
            ->getClass()
            ->getPaymentMethodsForCustomer(auth('sanctum')->user()->id);

        $results = collect($cards['data'])->map(function ($item) {
            return [
                'id' => $item['id'],
                'card_type' => $item['card']['brand'],
                'card_expiry_date' => $item['card']['exp_month'] . '/' . $item['card']['exp_year'],
                'formatted_card_number' => $item['card']['last4'],
                'card_number' => $item['card']['last4'],
            ];
        });


        return response()->json($results);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateSellerCardDetails $updateSellerCardDetails, CreateCard $createCard)
    {
        $result = $createCard->handle($updateSellerCardDetails);

        return $result ? $this->success($result, 'Card Created') : $this->error($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, UpdateCard $updateCard)
    {
        $result = $updateCard->handle($request, $id);

        $response = [
                'id' => $result['id'],
                'card_type' => $result['card']['brand'],
                'card_expiry_date' => $result['card']['exp_month'] . '/' . $result['card']['exp_year'],
                'formatted_card_number' => $result['card']['last4'],
                'card_number' => $result['card']['last4'],
            ];

        return $result ? $this->success($response, 'Card Updated') : $this->error($result);
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
        $userBankAccount = SellerBankDetails::where('seller_id', auth('sanctum')->user()->id)
            ->where('type', 'bank')
            ->first();

        $bankAccount = (new PaymentProviderFactory())
            ->getClass()
            ->getBankAccount(auth('sanctum')->user()->id, $userBankAccount->payment_method_id);

        $response = [
            'account_name' => $bankAccount['account_holder_name'],
            'account_number' => $bankAccount['last4'],
            'sort_code' => $bankAccount['routing_number'],
            'bank_name' => $bankAccount['bank_name'],
        ];
        return response()->json($response);
    }

    public function deleteBankAccount(int $id, DeleteBankAccount $deleteBankAccount)
    {
        $result = $deleteBankAccount->handle($id);

        return $result ? $this->success($result, 'Bank Account Removed') : $this->error('Unable to remove bank account');
    }

    public function saveBankDetails(UpdateSellerBankDetails $updateSellerBankDetails, SaveBankAccount $saveBankAccount)
    {
        $sellerBankDetails = $saveBankAccount->handle($updateSellerBankDetails);

        if (!$sellerBankDetails) {
            return $this->error('Unable to save bank details');
        }

        return $this->success($sellerBankDetails, 'bank details updated');
    }
}
