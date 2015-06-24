<?php namespace Symposium\Http\Controllers\Api;

use App;
use Exception;
use Symposium\ApiResources\Talk;
use Symposium\OAuthGuard\Facades\OAuthGuard;

class TalksController extends BaseController
{
    public function show($id)
    {
        try {
            $talk = OAuthGuard::user()->talks()->findOrFail($id);
        } catch (Exception $e) {
            App::abort(404);
        }

        $talk = new Talk($talk);

        return response()->jsonApi([
            'data' => $talk->toArray()
        ]);
    }
}
