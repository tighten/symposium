<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\AuthorizerFacade as Authorizer;
use Symposium\ApiResources\Bio;
use User;

class BiosController extends BaseController
{
    public function show($id)
    {
        $user = User::find(Authorizer::getResourceOwnerId());
        $bio = $user->bios()->findOrFail($id);

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
