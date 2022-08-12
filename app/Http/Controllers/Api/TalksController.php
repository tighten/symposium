<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Talk;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\App;

class TalksController extends Controller
{
    public function show($id)
    {
        try {
            $talk = auth()->guard('api')->user()->talks()->findOrFail($id);
        } catch (Exception $e) {
            App::abort(404);
        }

        $talk = new Talk($talk);

        return response()->jsonApi([
            'data' => $talk->toArray(),
        ]);
    }
}
