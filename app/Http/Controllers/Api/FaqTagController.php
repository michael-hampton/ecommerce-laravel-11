<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FaqTag;
use Illuminate\Http\Request;

class FaqTagController extends Controller
{
    public function index()
    {
        $tags = FaqTag::all();

        return response()->json($tags);
    }
}
