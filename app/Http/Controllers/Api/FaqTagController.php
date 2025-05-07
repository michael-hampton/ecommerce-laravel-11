<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FaqTag;

class FaqTagController extends Controller
{
    public function index()
    {
        $tags = FaqTag::all();

        return response()->json($tags);
    }
}
