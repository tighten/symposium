<?php namespace Symposium\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
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
         return Response::json($this->authorizer->issueAccessToken());
    }

    public function getAuthorize()
    {
        $params = $this->authorizer->getAuthCodeRequestParams();
        $params['client_id'] = $params['client']->getId(); // @todo wtf, why are we having to do this manually?

        return View::make('oauth/authorization-form', ['params' => $params]);
    }

    public function postAuthorize()
    {
        $params['user_id'] = Auth::user()->id;

        $redirectUri = '';

        if (Input::get('approve') !== null) {
            $redirectUri = $this->authorizer->issueAuthCode('user', $params['user_id'], $params);
        }

        if (Input::get('deny') !== null) {
            $redirectUri = $this->authorizer->authCodeRequestDeniedRedirectUri();
        }

        return Redirect::to($redirectUri);
    }
}
