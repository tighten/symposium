<?php

namespace App\Http\Controllers\Api;

use App;
use App\ApiResources\Bio;
use Exception;
use Illuminate\Support\Facades\Auth;

class BiosController extends BaseController
{
    public function show($id)
    {
        try {
            $bio = Auth::guard('api')->user()->bios()->findOrFail($id);
        } catch (Exception $e) {
            App::abort(404);
        }

        $bio = new Bio($bio);

        return response()->jsonApi([
            'data' => $bio->toArray()
        ]);
    }
}
