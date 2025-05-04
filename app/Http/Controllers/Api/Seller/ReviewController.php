<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewReplyRequest;
use App\Http\Resources\ProductReviewResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\SellerReviewResource;
use App\Models\Product;
use App\Models\Review;
use App\Repositories\Interfaces\ISellerRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\ISellerService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ReviewController extends ApiController
{
    public function __construct(
        private ISellerRepository $sellerRepository,
        private IUserRepository $userRepository,
        private ISellerService $sellerService
    ) {

    }

    public function index(Request $request)
    {

        $seller = $this->userRepository->getById(auth('sanctum')->user()->id);
        $sellerReviews = SellerReviewResource::collection($seller->reviews()->whereNull('parent_id')->get());
        
        
        $reviews = $seller->products()->with('reviews')
        ->whereHas('reviews', function (Builder $query) {
            return $query->whereNull('parent_id');
        })
        ->get()->map(function ($item) {
            if ($item->has('reviews')) {
                return $item->reviews;
            }

            return false;
        })->flatten();

       $reviews = $reviews->filter(function (Review $review) {
        return $review->parent_id === null;
       });


        $productReviews = ProductReviewResource::collection($reviews);


        return response()->json(
            array_merge(
                json_decode($sellerReviews->toJson(), true),
                json_decode($productReviews->toJson(), true)
            )
        );
    }

    public function createReply(ReviewReplyRequest $request)
    {
        $parent = Review::findOrFail($request->integer('reviewId'));

        $result = $parent->commentable->reviews()->create([
            'parent_id' => $request->integer('reviewId'),
            'comment' => $request->string('reply'),
            'user_id' => auth('sanctum')->user()->id,
            'seller_id' => auth('sanctum')->user()->id
        ]);

        if (!$result) {
            return $this->error('Unable to create reply');
        }

        $response = $parent->commentable_type === Product::class ? ProductReviewResource::make($parent->fresh()) : SellerReviewResource::make($parent->fresh());

        return $this->success($response, 'Reply was created');
    }
}
