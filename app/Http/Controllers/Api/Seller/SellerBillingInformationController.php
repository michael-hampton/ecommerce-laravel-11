<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerBankDetails;
use App\Models\SellerBillingInformation;
use Illuminate\Http\Request;

class SellerBillingInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = SellerBillingInformation::updateOrCreate(
            ['seller_id' => auth('sanctum')->user()->id],
            array_merge($request->all(), ['seller_id' => auth('sanctum')->id()])
        );


        if (!$result) {
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
