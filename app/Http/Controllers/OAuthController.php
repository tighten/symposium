<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Authorizer;

class OAuthController extends Controller
{
    protected $authorizer;

    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    public function postAccessToken()
    {
         return response()->json($this->authorizer->issueAccessToken());
    }

    public function getAuthorize()
    {
        $params = $this->authorizer->getAuthCodeRequestParams();
        $params['client_id'] = $params['client']->getId(); // @todo wtf, why are we having to do this manually?

        return view('oauth/authorization-form', ['params' => $params]);
    }

    public function postAuthorize(Request $request)
    {
        $params['user_id'] = Auth::user()->id;

        $redirectUri = '';

        if ($request->input('approve') !== null) {
            $redirectUri = $this->authorizer->issueAuthCode('user', $params['user_id'], $params);
        }

        if ($request->input('deny') !== null) {
            $redirectUri = $this->authorizer->authCodeRequestDeniedRedirectUri();
        }

        return redirect($redirectUri);
    }
}
