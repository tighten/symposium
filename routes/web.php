<?php

/**
 * Public
 */
Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@show',
]);

Route::get('what-is-this', function () {
    return view('what-is-this');
});

Route::get('speakers', [
    'as' => 'speakers-public.index',
    'uses' => 'PublicProfileController@index',
]);
Route::post('speakers', [
    'as' => 'speakers-public.search',
    'uses' => 'PublicProfileController@search',
]);
Route::get('u/{profileSlug}', [
    'as' => 'speakers-public.show',
    'uses' => 'PublicProfileController@show',
]);
Route::get('u/{profileSlug}/talks/{talkId}', [
    'as' => 'speakers-public.talks.show',
    'uses' => 'PublicProfileController@showTalk',
]);
Route::get('u/{profileSlug}/bios/{bioId}', [
    'as' => 'speakers-public.bios.show',
    'uses' => 'PublicProfileController@showBio',
]);
Route::get('u/{profileSlug}/email', [
    'as' => 'speakers-public.email',
    'uses' => 'PublicProfileController@getEmail',
]);
Route::post('u/{profileSlug}/email', [
    'as' => 'speakers-public.email',
    'uses' => 'PublicProfileController@postEmail',
]);

/*
 * App
 */
Route::get('log-out', ['as' => 'log-out', 'uses' => 'Auth\LoginController@logout']);

// Disable email registration
Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('account', ['as' => 'account.show', 'uses' => 'AccountController@show']);
    Route::get('account/edit', ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
    Route::put('account/edit', 'AccountController@update');
    Route::get('account/delete', ['as' => 'account.delete', 'uses' => 'AccountController@delete']);
    Route::post('account/delete', 'AccountController@destroy')->name('account.delete.confirm');
    Route::get('account/export', ['as' => 'account.export', 'uses' => 'AccountController@export']);
    Route::get('account/oauth-settings', ['as' => 'account.oauth-settings', 'uses' => 'AccountController@oauthSettings']);

    Route::post('acceptances', 'AcceptancesController@store');
    Route::delete('acceptances/{acceptance}', 'AcceptancesController@destroy');

    Route::post('submissions', 'SubmissionsController@store');
    Route::delete('submissions/{submission}', 'SubmissionsController@destroy');

    Route::get('conferences/{id}/favorite', 'ConferencesController@favorite');
    Route::get('conferences/{id}/unfavorite', 'ConferencesController@unfavorite');

    Route::get('conferences/{id}/dismiss', 'ConferencesController@dismiss');
    Route::get('conferences/{id}/undismiss', 'ConferencesController@undismiss');

    Route::get('calendar', ['as' => 'calendar.index', 'uses' => 'CalendarController@index']);

    // Necessary for GET-friendly delete because lazy
    Route::get('talks/{id}/delete', ['as' => 'talks.delete', 'uses' => 'TalksController@destroy']);
    Route::get('conferences/{id}/delete', ['as' => 'conferences.delete', 'uses' => 'ConferencesController@destroy']);
    Route::get('bios/{id}/delete', ['as' => 'bios.delete', 'uses' => 'BiosController@destroy']);

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
    Route::get('archive', ['as' =>'talks.archived.index', 'uses' => 'TalksController@archiveIndex']);
    Route::get('talks/{id}/archive', ['as' => 'talks.archive', 'uses' => 'TalksController@archive']);
    Route::get('talks/{id}/restore', ['as' => 'talks.restore', 'uses' => 'TalksController@restore']);
    Route::resource('talks', 'TalksController');
    Route::resource('conferences', 'ConferencesController', [
        'except' => ['index', 'show'],
    ]);
    Route::resource('bios', 'BiosController');
});

Route::get('conferences', ['as' => 'conferences.index', 'uses' => 'ConferencesController@index']);
Route::get('conferences/{id}', ['as' => 'conferences.show', 'uses' => 'ConferencesController@show']);

// Social logins routes
Route::group(['middleware' => ['social', 'guest']], function () {
    Route::get('login/{service}', 'Auth\SocialLoginController@redirect');
    Route::get('login/{service}/callback', 'Auth\SocialLoginController@callback');
});
