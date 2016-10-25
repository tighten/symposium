<?php namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\App;
use App\ApiResources\Talk;
use App\OAuthGuard\Facades\OAuthGuard;
use App\Models\User;

class UserTalksController extends BaseController
{
    /**
     * Display all of the given user's talks
     *
     * @return Response
     */
    public function index($userId)
    {
        if ($userId != OAuthGuard::user()->id) {
            App::abort(404);
        }

        $return = OAuthGuard::user()->talks->map(function ($talk) {
            return new Talk($talk);
        })->values();

        return response()->jsonApi([
            'data' => $return
        ]);
    }
}
