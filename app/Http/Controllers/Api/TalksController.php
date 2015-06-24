<?php namespace Symposium\Http\Controllers\Api;

use App;
use Exception;
use Symposium\ApiResources\Talk;
use Symposium\oAuthGuard\Facades\oAuthGuard;

class TalksController extends BaseController
{
    public function show($id)
    {
        try {
            $talk = oAuthGuard::user()->talks()->findOrFail($id);
        } catch (Exception $e) {
            App::abort(404);
        }

        $talk = new Talk($talk);

        return response()->jsonApi([
            'data' => $talk->toArray()
        ]);
    }
}
