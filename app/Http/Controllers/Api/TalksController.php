<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Symposium\ApiResources\Talk;

class TalksController extends BaseController
{
    public function show($id)
    {
        $talk = Auth::user()->talks()->findOrFail($id);

        $talk = new Talk($talk);

        return response()->jsonApi([
            'data' => [
                'id' => $talk->getId(),
                'type' => $talk->getType(),
                'attributes' => $talk->attributes()
            ]
        ]);
    }
}
