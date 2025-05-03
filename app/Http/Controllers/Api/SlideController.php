<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSlideRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateSlideRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\SlideResource;
use App\Repositories\Interfaces\ISlideRepository;
use App\Services\Interfaces\ISlideService;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class SlideController extends ApiController
{
    public function __construct(private ISlideRepository $slideRepository, private ISlideService $slideService)
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchRequest $request)
    {
        $slides = $this->slideRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['name' => $request->get('searchText'), 'ignore_active' => true]
        );

        return $this->sendPaginatedResponse($slides, SlideResource::collection($slides));
    }

    /**
     * @param CreateSlideRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSlideRequest $request)
    {
        $result = $this->slideService->createSlide($request->all());

        if (!$result) {
            return $this->error('Unable to create Slide');
        }

        return $this->success($result, 'Slide created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * @param UpdateSlideRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSlideRequest $request, $id)
    {
        $result = $this->slideService->updateSlide($request->validated(), $id);

        if (!$result) {
            return $this->error('Unable to update Slide');
        }

        return $this->success($result, 'Slide updated');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->slideService->deleteSlide($id);

        if (!$result) {
            return $this->error('Unable to delete Slide');
        }

        return $this->success($result, 'Slide deleted');
    }

    public function toggleActive(int $id)
    {
        $result = $this->slideService->toggleActive($id);

        if (!$result) {
            return $this->error('Unable to update Slide');
        }

        return $this->success($result, 'Slide updated');
    }
}
