<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryFeedController extends Controller
{
    public function __invoke(Request $request , $type  , $parent = false): JsonResponse
    {
        $items = Category::query()
            ->latest()
            ->where('type' , $type)
            ->when($parent ,function ($q) {
                $q->whereNull('parent_id');
            })
            ->take(15)
            ->select2()
            ->search($request->query('search'))
            ->cursor();

        return response()->json($items);
    }
}
