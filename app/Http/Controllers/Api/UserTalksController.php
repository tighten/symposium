<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Talk;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class UserTalksController extends Controller
{
    /**
     * Display all of the given user's talks
     */
    public function index($userId): JsonResponse
    {
        if ($userId != auth()->guard('api')->user()->id) {
            App::abort(404);
        }

        $talks = auth()->guard('api')
            ->user()
            ->talks()
            ->withCurrentRevision()
            ->when((bool) request()->query('include-archived'), function ($query) {
                $query->withoutGlobalScope('active');
            })
            ->get()
            ->sortByTitle()
            ->map(function ($talk) {
                return new Talk($talk);
            })->values();

        return response()->jsonApi([
            'data' => $talks,
        ]);
    }
}
