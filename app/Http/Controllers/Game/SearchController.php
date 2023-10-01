<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $this->validate($request, [
            'query' => 'sometimes|string',
        ]);

        $games = Game::search($request->input('query'))
            ->where('user_id', auth()->user()->id)
            ->get()
            ->values();

        return response()->json([
            'message' => '',
            'status' => 'success',
            'data' => compact('games'),
        ]);
    }
}
