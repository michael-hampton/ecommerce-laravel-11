<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Notifications\FeedbackReceived;
use App\Repositories\Interfaces\IProductRepository;
use Auth;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function __construct(private readonly IProductRepository $productRepository) {}

    public function index(int $sellerId)
    {
        User::with(['reviews', 'reviews.replies'])->findOrFail($sellerId);

        $profile = Profile::where('user_id', $sellerId)->first();

        $currency = config('shop.currency');

        $sellerProducts = $this->productRepository->getPaginated(10, 'created_at', 'desc', ['seller_id' => auth()->id()]);

        return view('front.seller.index', ['seller' => $seller, 'profile' => $profile, 'sellerProducts' => $sellerProducts, 'currency' => $currency]);
    }

    public function store(Request $request, int $sellerId)
    {
        if (! Auth::check()) {
            return redirect()->back()->with('error', 'Not logged in');
        }

        $seller = User::whereId($sellerId)->first();
        $review = $seller->reviews()->create([
            'comment' => $request->input('review'),
            'rating' => $request->input('rating'),
            'user_id' => auth()->user()->id,
        ]);

        $seller->notify(new FeedbackReceived($review));

        return redirect()->back()->with('message', 'Review was added successfully!');
    }
}
