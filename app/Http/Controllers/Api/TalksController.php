<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\ApiResources\Talk;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\App;

class TalksController extends Controller
{
    public function show($id): Response
    {
        try {
            $talk = auth()->guard('api')->user()->talks()->withCurrentRevision()->findOrFail($id);
        } catch (Exception $e) {
            App::abort(404);
        }

        $talk = new Talk($talk);

        return response()->jsonApi([
            'data' => $talk->toArray(),
        ]);
    }
}
