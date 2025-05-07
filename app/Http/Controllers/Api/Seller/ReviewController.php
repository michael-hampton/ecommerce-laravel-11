<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ReviewReplyRequest;
use App\Http\Resources\ProductReviewResource;
use App\Http\Resources\SellerReviewResource;
use App\Models\Product;
use App\Models\Review;
use App\Repositories\Interfaces\ISellerRepository;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReviewController extends ApiController
{
    public function __construct(
        private IUserRepository $userRepository,
    ) {}

    public function index(Request $request)
    {

        $seller = $this->userRepository->getById(auth('sanctum')->user()->id);
        $anonymousResourceCollection = SellerReviewResource::collection($seller->reviews()->whereNull('parent_id')->get());

        $reviews = $seller->products()->with('reviews')
            ->whereHas('reviews', function (Builder $builder) {
                return $builder->whereNull('parent_id');
            })
            ->get()->map(function ($item) {
                if ($item->has('reviews')) {
                    return $item->reviews;
                }

                return false;
            })->flatten();

        $reviews = $reviews->filter(function (Review $review): bool {
            return $review->parent_id === null;
        });

        $productReviews = ProductReviewResource::collection($reviews);

        return response()->json(
            array_merge(
                json_decode($anonymousResourceCollection->toJson(), true),
                json_decode($productReviews->toJson(), true)
            )
        );
    }

    public function createReply(ReviewReplyRequest $reviewReplyRequest)
    {
        $parent = Review::findOrFail($reviewReplyRequest->integer('reviewId'));

        $result = $parent->commentable->reviews()->create([
            'parent_id' => $reviewReplyRequest->integer('reviewId'),
            'comment' => $reviewReplyRequest->string('reply'),
            'user_id' => auth('sanctum')->user()->id,
            'seller_id' => auth('sanctum')->user()->id,
        ]);

        if (! $result) {
            return $this->error('Unable to create reply');
        }

        $response = $parent->commentable_type === Product::class ? ProductReviewResource::make($parent->fresh()) : SellerReviewResource::make($parent->fresh());

        return $this->success($response, 'Reply was created');
    }
}
