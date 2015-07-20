<?php

Route::get('/', function () {
    return View::make('home');
});

Route::get('what-is-this', function () {
    return View::make('what-is-this');
});

Route::get('log-in', ['as' => 'log-in', 'uses' => 'AuthController@getLogin']);
Route::post('log-in', 'AuthController@postLogin');
Route::get('log-out', ['as' => 'log-out', 'uses' => 'AuthController@logout']);

Route::get('sign-up', ['as' => 'sign-up', 'uses' => 'AccountController@create']);
Route::post('sign-up', 'AccountController@store');

// Route::get('s/{shareId}', 'TalksController@showPublic');

// temp fix
Route::get('conferences/create', ['as' => 'conferences.create', 'uses' => 'ConferencesController@create', 'middleware' => 'auth']);

Route::get('conferences/{id}', ['as' => 'conferences.public', 'uses' => 'ConferencesController@show']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('account', ['as' => 'account.show', 'uses' => 'AccountController@show']);
    Route::get('account/edit', ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
    Route::put('account/edit', 'AccountController@update');
    Route::get('account/delete', ['as' => 'account.delete', 'uses' => 'AccountController@delete']);
    Route::post('account/delete', 'AccountController@destroy');
    Route::get('account/export', ['as' => 'account.export', 'uses' => 'AccountController@export']);

    Route::post('submissions', 'SubmissionsController@store');
    Route::delete('submissions', 'SubmissionsController@destroy');

    // Joind.in (@todo separate controller)
    Route::get('conferences/joindin/import/{eventId}', 'ConferencesController@joindinImport');
    Route::get('conferences/joindin/import', 'ConferencesController@joindinImportList');
    Route::get('conferences/joindin/all', 'ConferencesController@joindinImportAll');

    Route::get('conferences/{id}/favorite', 'ConferencesController@favorite');
    Route::get('conferences/{id}/unfavorite', 'ConferencesController@unfavorite');

    // Necessary for GET-friendly delete because lazy
    Route::get('talks/{id}/delete', ['as' => 'talks.delete', 'uses' => 'TalksController@destroy']);
    Route::get('conferences/{id}/delete', ['as' => 'conferences.delete', 'uses' => 'ConferencesController@destroy']);
    Route::get('bios/{id}/delete', ['as' => 'bios.delete', 'uses' => 'BiosController@destroy']);

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
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
    Route::get('oauth/authorize', [
        'before' => 'check-authorization-params|auth',
        'as' => 'get-oauth-authorize',
        'uses' => 'OAuthController@getAuthorize'
    ]);

    Route::post('oauth/authorize', [
        'before' => 'csrf|check-authorization-params|auth',
        'as' => 'post-oauth-authorize',
        'uses' => 'OAuthController@postAuthorize'
    ]);
});

Route::post('oauth/access-token', [
    'as' => 'oauth-access-token',
    'uses' => 'OAuthController@postAccessToken'
]);
