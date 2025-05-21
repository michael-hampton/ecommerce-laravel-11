<?php



namespace App\Http\Controllers\Api\Support;

use App\Http\Controllers\Api\ApiController;
use App\Models\FaqTag;

class FaqTagController extends ApiController
{
    public function index()
    {
        $tags = FaqTag::all();

        return response()->json($tags);
    }
}
