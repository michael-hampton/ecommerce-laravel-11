<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostReplyRequest;
use App\Http\Resources\MessageResource;
use App\Repositories\Interfaces\IMessageRepository;
use App\Services\Interfaces\IMessageService;
use Illuminate\Http\Request;

class MessageController extends ApiController
{
    public function __construct(private IMessageRepository $messageRepository, private IMessageService $messageService)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $messages = $this->messageRepository->getPaginated(
            $request->integer('limit'),
            $request->string('sortBy'),
            $request->boolean('sortAsc') === true ? 'asc' : 'desc',
            ['name' => $request->get('searchText')]
        );

        return $this->sendPaginatedResponse($messages, MessageResource::collection($messages));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostReplyRequest $request)
    {
        $result = $this->messageService->createComment([
            'user_id' => auth('sanctum')->user()->id,
            'post_id' => $request->integer('postId'),
            'message' => $request->string('message')
        ]);

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->messageRepository->getById($id);

        return response()->json(MessageResource::make($result));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $result = $this->messageRepository->update($id, $request->all());
        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->messageService->deleteMessage($id);
        return response()->json($result);
    }
}
