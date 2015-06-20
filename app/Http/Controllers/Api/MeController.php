<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\AuthorizerFacade as Authorizer;
use Symposium\ApiResources\Me;
use User;

class MeController extends BaseController
{
    public function index()
    {
        $me = new Me(User::find(Authorizer::getResourceOwnerId()));

        return response()->jsonApi([
            'data' => [
                'id' => $me->getId(),
                'type' => $me->getType(),
                'attributes' => $me->attributes()
            ]
        ]);
    }
}
