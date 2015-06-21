<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\App;
use Symposium\ApiResources\Talk;
use Symposium\oAuthGuard\Facades\oAuthGuard;
use User;

class UserTalksController extends BaseController
{
    /**
     * Display all of the given user's talks
     *
     * @return Response
     */
    public function index($userId)
    {
        if ($userId != oAuthGuard::user()->id) {
            App::abort(404);
        }

        $return = oAuthGuard::user()->talks->map(function ($talk) {
            $resource = new Talk($talk);

            return [
                'id' => $resource->getId(),
                'type' => $resource->getType(),
                'attributes' => $resource->attributes()
            ];
        });

        return response()->jsonApi([
            'data' => $return
        ]);
    }
}
