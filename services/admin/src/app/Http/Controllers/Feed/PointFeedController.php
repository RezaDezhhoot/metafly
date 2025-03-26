<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Models\Point;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PointFeedController extends Controller
{
    public function __invoke(Request $request ): JsonResponse
    {
        $items = Point::query()
            ->latest()
            ->take(15)
            ->select2()
            ->search($request->query('search'))
            ->cursor();

        return response()->json($items);
    }
}
