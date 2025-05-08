<?php



namespace App\Http\Controllers\Api\Seller;

use App\Actions\Seller\SaveBillingInformation;
use App\Http\Controllers\Controller;
use App\Models\SellerBillingInformation;
use Illuminate\Http\Request;

class SellerBillingInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, SaveBillingInformation $saveBillingInformation)
    {
        $result = $saveBillingInformation->handle($request);

        if (! $result) {
            return $this->error('Unable to update billing details');
        }

        return $this->success($result, 'billing details updated');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $result = SellerBillingInformation::where('seller_id', auth('sanctum')->id())->first();

        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        //
    }
}
