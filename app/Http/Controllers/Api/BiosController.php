<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Bio;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class BiosController extends Controller
{
    public function show($id): JsonResponse
    {
        try {
            $bio = auth()->guard('api')->user()->bios()->findOrFail($id);
        } catch (Exception $e) {
            App::abort(404);
        }

        $bio = new Bio($bio);

        return response()->jsonApi([
            'data' => $bio->toArray(),
        ]);
    }
}
