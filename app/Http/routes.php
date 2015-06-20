<?php

Route::get('/', function () {
    return View::make('home');
});

Route::get('what-is-this', function () {
    return View::make('what-is-this');
});

Route::get('log-in', 'AuthController@getLogin');
Route::post('log-in', 'AuthController@postLogin');
Route::get('log-out', 'AuthController@logout');

Route::get('sign-up', 'AccountController@create');
Route::post('sign-up', 'AccountController@store');

// Route::get('s/{shareId}', 'TalksController@showPublic');

// temp fix
Route::get('conferences/create', ['as' => 'conferences.create', 'uses' => 'ConferencesController@create', 'middleware' => 'auth']);

Route::get('conferences/{id}', ['as' => 'conferences.public', 'uses' => 'ConferencesController@show']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('account', 'AccountController@show');
    Route::get('account/edit', 'AccountController@edit');
    Route::put('account/edit', 'AccountController@update');
    Route::get('account/delete', 'AccountController@delete');
    Route::post('account/delete', 'AccountController@destroy');
    Route::get('account/export', 'AccountController@export');

    Route::post('submissions', 'SubmissionsController@store');
    Route::delete('submissions', 'SubmissionsController@destroy');

    // Joind.in (@todo separate controller)
    Route::get('conferences/joindin/import/{eventId}', 'ConferencesController@joindinImport');
    Route::get('conferences/joindin/import', 'ConferencesController@joindinImportList');
    Route::get('conferences/joindin/all', 'ConferencesController@joindinImportAll');

    Route::get('conferences/{id}/favorite', 'ConferencesController@favorite');
    Route::get('conferences/{id}/unfavorite', 'ConferencesController@unfavorite');

    // Necessary for GET-friendly delete because lazy
    Route::get('talks/{id}/delete', 'TalksController@destroy');
    Route::get('conferences/{id}/delete', 'ConferencesController@destroy');

    Route::resource('talks', 'TalksController');
    Route::resource('conferences', 'ConferencesController');
    Route::resource('bios', 'BiosController');
});

Route::group(['prefix' => 'api', 'namespace' => 'Api', 'before' => 'oauth'], function () {
    Route::get('me', 'MeController@index');
    Route::get('bios/{bioId}', 'BiosController@show');
    Route::get('user/{userId}/bios', 'UserBiosController@index');
    Route::get('talks/{talkId}', 'TalksController@show');
    Route::get('user/{userId}/talks', 'UserTalksController@index');
    Route::get('conferences/{id}', 'ConferencesController@show');
    Route::get('conferences', 'ConferencesController@index');
});

Route::group(['middleware' => 'auth'], function () {
    // oAuth
    //
    // Test: http://symposiumapp.app:8000/oauth/authorize?client_id=1&redirect_uri=http://mattstauffer.co/&response_type=code
    // forwards you to mattstauffer.co/?code=code-for-getting-token-below
    // then pass that code to oauth/access-token to get your info
    // curl -u client_id:client_secret http://symposiumapp.app:8000/oauth/access-token -d 'grant_type=authorization_code&code=code-from-redirect-above&redirect_uri=http://mattstauffer.co/'
    // and finally you can authorize your requests using the provided token:
    // http://up.stauffe.red/image/241t3g0e1C0j
    //
    // ... requires you've added client id of one to to the oauth_clients table and a connected entry to the oauth_client_endpoints table
    Route::get('oauth/authorize', ['before' => 'check-authorization-params|auth', 'as' => 'get-oauth-authorize', function () {
        $params = Authorizer::getAuthCodeRequestParams();
        $params['client_id'] = Input::get('client_id'); // @todo wtf, why are we having to do this manually?
        return View::make('oauth/authorization-form', ['params' => $params]);
    }]);

    Route::post('oauth/authorize', ['before' => 'csrf|check-authorization-params|auth', 'as' => 'post-oauth-authorize', function () {
        $params['user_id'] = Auth::user()->id;

        $redirectUri = '';

        // If the user has allowed the client to access its data, redirect back to the client with an auth code
        if (Input::get('approve') !== null) {
            $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
        }

        // If the user has denied the client to access its data, redirect back to the client with an error message
        if (Input::get('deny') !== null) {
            $redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
        }

        return Redirect::to($redirectUri);
    }]);
});

Route::post('oauth/access-token', ['as' => 'oauth-access-token', function () {
    return Response::json(Authorizer::issueAccessToken());
}]);
