<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Repositories\Interfaces\IProductRepository;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private IProductRepository $productRepository)
    {

    }

    public function store(Request $request, int $productId)
    {
        $product = $this->productRepository->getById($productId);
        $product->reviews()->create([
            'comment' => $request->input("review"),
            'rating' => $request->input("rating"),
            'user_id' => auth()->id()
        ]);
        OrderItem::whereId($request->input("orderItemId"))->update(['review_status' => true]);

        return redirect()->back()->with('message', 'Review was added successfully!');
    }

    public function create(int $orderItemId)
    {
        $orderItem = OrderItem::whereId($orderItemId)->first();

        $product = $orderItem->product;
        return view('user.user-review', compact('product', 'orderItem'));
    }
}
