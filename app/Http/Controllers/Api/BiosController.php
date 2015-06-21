<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Symposium\ApiResources\Bio;
use Symposium\oAuthGuard\Facades\oAuthGuard;
use User;

class BiosController extends BaseController
{
    public function show($id)
    {
        $bio = oAuthGuard::user()->bios()->findOrFail($id);

        $bio = new Bio($bio);

        return response()->jsonApi([
            'data' => [
                'id' => $bio->getId(),
                'type' => $bio->getType(),
                'attributes' => $bio->attributes()
            ]
        ]);
    }
}
