<?php namespace Symposium\Http\Controllers\Api;

use App;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symposium\ApiResources\Bio;
use Symposium\oAuthGuard\Facades\oAuthGuard;
use User;

class BiosController extends BaseController
{
    public function show($id)
    {
        try {
            $bio = oAuthGuard::user()->bios()->findOrFail($id);
        } catch (Exception $e) {
            App::abort(404);
        }

        $bio = new Bio($bio);

        return response()->jsonApi([
            'data' => $bio->toArray()
        ]);
    }
}
