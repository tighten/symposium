<?php namespace Symposium\Http\Controllers\Api;

use Symposium\ApiResources\Talk;
use Symposium\oAuthGuard\Facades\oAuthGuard;

class TalksController extends BaseController
{
    public function show($id)
    {
        $talk = oAuthGuard::user()->talks()->findOrFail($id);

        $talk = new Talk($talk);

        return response()->jsonApi([
            'data' => $talk->toArray()
        ]);
    }
}
