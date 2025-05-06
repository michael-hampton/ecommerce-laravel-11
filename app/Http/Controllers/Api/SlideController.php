<?php



namespace App\Http\Controllers\Api;

use App\Actions\ActivateSlide;
use App\Actions\CreateSlide;
use App\Actions\DeleteSlide;
use App\Actions\UpdateSlide;
use App\Http\Requests\CreateSlideRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateSlideRequest;
use App\Http\Resources\SlideResource;
use App\Repositories\Interfaces\ISlideRepository;
use Illuminate\Http\Request;

class SlideController extends ApiController
{
    public function __construct(private ISlideRepository $slideRepository) {}

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchRequest $request)
    {
        $slides = $this->slideRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->string('sortDir'),
            ['name' => $request->get('searchText'), 'ignore_active' => true]
        );

        return $this->sendPaginatedResponse($slides, SlideResource::collection($slides));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSlideRequest $request, CreateSlide $createSlide)
    {
        $result = $createSlide->handle($request->all());

        if (! $result) {
            return $this->error('Unable to create Slide');
        }

        return $this->success($result, 'Slide created');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSlideRequest $request, $id, UpdateSlide $updateSlide)
    {
        $result = $updateSlide->handle($request->except(['_method']), $id);

        if (! $result) {
            return $this->error('Unable to update Slide');
        }

        return $this->success($result, 'Slide updated');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DeleteSlide $deleteSlide)
    {
        $result = $deleteSlide->handle($id);

        if (! $result) {
            return $this->error('Unable to delete Slide');
        }

        return $this->success($result, 'Slide deleted');
    }

    public function toggleActive(int $id, ActivateSlide $activateSlide)
    {
        $result = $activateSlide->handle($id);

        if (! $result) {
            return $this->error('Unable to update Slide');
        }

        return $this->success($result, 'Slide updated');
    }
}
