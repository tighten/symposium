<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symposium\ApiResources\Bio;
use User;

class UserBiosController extends BaseController
{
    /**
     * Display all of the given user's bios
     *
     * @return Response
     */
    public function index($userId)
    {
        if ($userId != Auth::user()->id) {
            App::abort(404);
        }

        $bios = User::find($userId)->bios;

        $return = [];

        foreach ($bios as $bio) {
            $resource = new Bio($bio);

            $return[] = [
                'id' => $resource->getId(),
                'type' => $resource->getType(),
                'attributes' => $resource->attributes()
            ];
        }

        return response()->jsonApi([
            'data' => $return
        ]);
    }
}
