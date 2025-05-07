<?php



namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    /**
     * success response method.
     *
     * @return Response
     */
    public function success($result, string $message, int $code = Response::HTTP_OK)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @return Response
     */
    public function error(string $error, array $errorMessages = [], int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
            'errors' => $errorMessages,
        ];

        if (! empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function sendPaginatedResponse(Paginator $items, JsonResource $data): JsonResponse
    {
        $response = [
            'current_page' => $items->currentPage(),
            'total' => $items->total(),
            'per_page' => $items->perPage(),
            'data' => $data];

        return \response()->json($response);
    }
}
