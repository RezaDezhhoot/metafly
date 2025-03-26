<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleFeedController extends Controller
{
    public function __invoke(Request $request ): JsonResponse
    {
        $items = Role::query()
            ->latest()
            ->take(15)
            ->select(['id','name as text'])
            ->when($request->filled('search') , function (Builder $builder) use ($request) {
                $builder->whereLike('name',"%".$request->get('search')."%");
            })
            ->cursor();

        return response()->json($items);
    }
}
