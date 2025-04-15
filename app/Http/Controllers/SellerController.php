<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function __construct(private IProductRepository $productRepository)
    {

    }

    public function index(int $sellerId)
    {
        $seller = auth()->user();

        $profile = Profile::where('user_id', $sellerId)->first();

        $currency = config("shop.currency");

        $sellerProducts = $this->productRepository->getPaginated(10, 'created_at', 'desc', ['seller_id' => auth()->id()]);


        return view('seller.index', compact('seller', 'profile', 'sellerProducts', 'currency'));
    }

    public function store(Request $request, int $sellerId)
    {
        $seller = User::whereId($sellerId)->first();
        $seller->reviews()->create([
            'comment' => $request->input("review"),
            'rating' => $request->input("rating"),
            'user_id' => auth()->id()
        ]);

        return redirect()->back()->with('message', 'Review was added successfully!');
    }
}
