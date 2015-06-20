<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\AuthorizerFacade as Authorizer;
use Symposium\ApiResources\Talk;
use User;

class TalksController extends BaseController
{
    public function show($id)
    {
        $user = User::find(Authorizer::getResourceOwnerId());

        $talk = $user->talks()->findOrFail($id);

        $talk = new Talk($talk);

        return response()->jsonApi([
            'data' => [
                'id' => $talk->getId(),
                'type' => $talk->getType(),
                'attributes' => $talk->attributes()
            ]
        ]);
    }
}
