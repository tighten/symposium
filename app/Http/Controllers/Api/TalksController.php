<?php

namespace App\Http\Controllers\Api;

use App;
use Exception;
use App\ApiResources\Talk;
use Illuminate\Support\Facades\Auth;

class TalksController extends BaseController
{
    public function show($id)
    {
        try {
            $talk = Auth::guard('api')->user()->talks()->findOrFail($id);
        } catch (Exception $e) {
            App::abort(404);
        }

        $talk = new Talk($talk);

        return response()->jsonApi([
            'data' => $talk->toArray()
        ]);
    }
}
