<?php namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\App;
use App\ApiResources\Bio;
use App\OAuthGuard\Facades\OAuthGuard;
use App\Models\User;

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
