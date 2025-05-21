<?php



namespace App\Http\Controllers\Api\Seller;

use App\Actions\Seller\CreateSeller;
use App\Actions\Seller\DeleteSeller;
use App\Actions\Seller\UpdateSeller;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateSellerActive;
use App\Http\Resources\SellerResource;
use App\Models\Profile;
use App\Repositories\Interfaces\ISellerRepository;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

class SellerController extends ApiController
{
    public function __construct(
        private readonly ISellerRepository $sellerRepository,
        private readonly IUserRepository $userRepository,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $searchRequest): JsonResponse
    {
        $sellers = $this->sellerRepository->getPaginatedWithFilters(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            $searchRequest->array('searchFilters')
        );

        return $this->sendPaginatedResponse($sellers, SellerResource::collection($sellers));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateSeller $createSeller)
    {
        $profile = $createSeller->handle(array_merge($request->all(), ['user_id' => auth('sanctum')->user()->id]));

        if (!$profile) {
            return $this->error('Unable to create Seller');
        }

        return $this->success($profile, 'Seller created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $result = $this->sellerRepository->getCollectionByColumn(auth('sanctum')->user()->id, 'user_id', 1)->first();

        return response()->json(SellerResource::make($result));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, UpdateSeller $updateSeller): JsonResponse
    {
        $result = $updateSeller->handle($request->all(), $id);

        if (!$result) {
            return $this->error('Unable to update Seller');
        }

        return $this->success(SellerResource::make($result), 'Seller updated');
    }

    public function toggleActive(UpdateSellerActive $updateSellerActive): JsonResponse
    {
        $result = Profile::whereId($updateSellerActive->integer('sellerId'))->update(['active' => $updateSellerActive->boolean('active')]);

        if (!$result) {
            return $this->error('Unable to create Seller');
        }

        return $this->success($result, 'Seller deleted');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, DeleteSeller $deleteSeller): JsonResponse
    {
        $result = $deleteSeller->handle($id);

        if (!$result) {
            return $this->error('Unable to create Seller');
        }

        return $this->success($result, 'Seller deleted');
    }
}
