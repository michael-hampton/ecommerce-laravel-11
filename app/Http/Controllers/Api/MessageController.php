<?php



namespace App\Http\Controllers\Api;

use App\Actions\Message\CreateComment;
use App\Actions\Message\DeleteMessage;
use App\Actions\Message\UpdateMessage;
use App\Http\Requests\PostReplyRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\MessageResource;
use App\Repositories\Interfaces\IMessageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class MessageController extends ApiController
{
    public function __construct(private readonly IMessageRepository $messageRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $searchRequest): JsonResponse
    {
        $messages = $this->messageRepository->setRequiredRelationships(['comments', 'user'])->getPaginated(
            $searchRequest->integer('limit'),
            $searchRequest->string('sortBy'),
            $searchRequest->string('sortDir'),
            ['name' => $searchRequest->get('searchText')]
        );

        return $this->sendPaginatedResponse($messages, MessageResource::collection($messages));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostReplyRequest $postReplyRequest, CreateComment $createComment): JsonResponse
    {
        Log::info($postReplyRequest->hasFile('images'));

        $result = $createComment->handle([
            'user_id' => auth('sanctum')->user()->id,
            'post_id' => $postReplyRequest->integer('postId'),
            'message' => $postReplyRequest->string('message'),
            'images' => $postReplyRequest->file('images'),
        ]);

        if (! $result) {
            return $this->error('Unable to create Message');
        }

        return $this->success($result, 'Message created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $result = $this->messageRepository->getById($id);

        return response()->json(MessageResource::make($result));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, UpdateMessage $updateMessage): Response
    {
        $result = $updateMessage->handle($request->all(), $id);

        if (! $result) {
            return $this->error('Unable to update Message');
        }

        return $this->success($result, 'Message updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, DeleteMessage $deleteMessage): Response
    {
        $result = $deleteMessage->handle($id);

        if (! $result) {
            return $this->error('Unable to delete Message');
        }

        return $this->success($result, 'Message deleted');
    }
}
