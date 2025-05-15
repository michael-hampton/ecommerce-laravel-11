<?php



namespace App\Http\Controllers\Api;

use App\Actions\Slide\ActivateSlide;
use App\Actions\Slide\CreateSlide;
use App\Actions\Slide\DeleteSlide;
use App\Actions\Slide\UpdateSlide;
use App\Http\Requests\CreateSlideRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateSlideRequest;
use App\Http\Resources\SlideResource;
use App\Repositories\Interfaces\ISlideRepository;
use Illuminate\Http\Request;

class SlideController extends ApiController
{
    public function __construct(private readonly ISlideRepository $slideRepository)
    {
    }

    /**
     * @param  Request  $searchRequest
     */
    public function index(SearchRequest $searchRequest): \Illuminate\Http\JsonResponse
    {
        $slides = $this->slideRepository->getPaginatedWithFilters(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            $searchRequest->array('searchFilters')
        );

        return $this->sendPaginatedResponse($slides, SlideResource::collection($slides));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSlideRequest $createSlideRequest, CreateSlide $createSlide)
    {
        $slide = $createSlide->handle($createSlideRequest->all());

        if (!$slide) {
            return $this->error('Unable to create Slide');
        }

        return $this->success($slide, 'Slide created');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): void
    {
        //
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSlideRequest $updateSlideRequest, int $id, UpdateSlide $updateSlide)
    {
        $result = $updateSlide->handle($updateSlideRequest->except(['_method']), $id);

        if (!$result) {
            return $this->error('Unable to update Slide');
        }

        return $this->success($result, 'Slide updated');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteSlide $deleteSlide)
    {
        $result = $deleteSlide->handle($id);

        if (!$result) {
            return $this->error('Unable to delete Slide');
        }

        return $this->success($result, 'Slide deleted');
    }

    public function toggleActive(int $id, ActivateSlide $activateSlide)
    {
        $result = $activateSlide->handle($id);

        if (!$result) {
            return $this->error('Unable to update Slide');
        }

        return $this->success($result, 'Slide updated');
    }
}
