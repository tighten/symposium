<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\App;
use Symposium\ApiResources\Bio;
use Symposium\OAuthGuard\Facades\OAuthGuard;
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
        if ($userId != OAuthGuard::user()->id) {
            App::abort(404);
        }

        $return = OAuthGuard::user()->bios->map(function ($bio) {
            return new Bio($bio);
        });

        return response()->jsonApi([
            'data' => $return
        ]);
    }
}
