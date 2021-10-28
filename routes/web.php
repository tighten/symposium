<?php

/**
 * Public
 */
Route::get('/', 'HomeController@show')->name('home');

Route::get('what-is-this', function () {
    return view('what-is-this');
});

Route::get('speakers', 'PublicProfileController@index')->name('speakers-public.index');
Route::post('speakers', 'PublicProfileController@search')->name('speakers-public.search');
Route::get('u/{profileSlug}', 'PublicProfileController@show')->name('speakers-public.show');
Route::get('u/{profileSlug}/talks/{talkId}', 'PublicProfileController@showTalk')->name('speakers-public.talks.show');
Route::get('u/{profileSlug}/bios/{bioId}', 'PublicProfileController@showBio')->name('speakers-public.bios.show');
Route::get('u/{profileSlug}/email', 'PublicProfileController@getEmail')->name('speakers-public.email');
Route::post('u/{profileSlug}/email', 'PublicProfileController@postEmail')->name('speakers-public.email.send');

/*
 * App
 */
Route::get('log-out', 'Auth\LoginController@logout')->name('log-out');

// Disable email registration
Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
    Route::get('account', 'AccountController@show')->name('account.show');
    Route::get('account/edit', 'AccountController@edit')->name('account.edit');
    Route::put('account/edit', 'AccountController@update');
    Route::get('account/delete', 'AccountController@delete')->name('account.delete');
    Route::post('account/delete', 'AccountController@destroy')->name('account.delete.confirm');
    Route::get('account/export', 'AccountController@export')->name('account.export');
    Route::get('account/oauth-settings', 'AccountController@oauthSettings')->name('account.oauth-settings');

    Route::post('acceptances', 'AcceptancesController@store');
    Route::delete('acceptances/{acceptance}', 'AcceptancesController@destroy');

    Route::post('rejections', 'RejectionController@store');
    Route::delete('rejections/{rejection}', 'RejectionController@destroy');

    Route::post('submissions', 'SubmissionsController@store');
    Route::delete('submissions/{submission}', 'SubmissionsController@destroy');

    Route::get('conferences/{id}/favorite', 'ConferencesController@favorite');
    Route::get('conferences/{id}/unfavorite', 'ConferencesController@unfavorite');

    Route::get('conferences/{id}/dismiss', 'ConferencesController@dismiss');
    Route::get('conferences/{id}/undismiss', 'ConferencesController@undismiss');

    Route::get('calendar', 'CalendarController@index')->name('calendar.index');

    // Necessary for GET-friendly delete because lazy
    Route::get('talks/{id}/delete', 'TalksController@destroy')->name('talks.delete');
    Route::get('conferences/{id}/delete', 'ConferencesController@destroy')->name('conferences.delete');
    Route::get('bios/{id}/delete', 'BiosController@destroy')->name('bios.delete');

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('archive', 'TalksController@archiveIndex')->name('talks.archived.index');
    Route::get('talks/{id}/archive', 'TalksController@archive')->name('talks.archive');
    Route::get('talks/{id}/restore', 'TalksController@restore')->name('talks.restore');
    Route::resource('talks', 'TalksController');
    Route::resource('conferences', 'ConferencesController')->except('index', 'show');
    Route::resource('bios', 'BiosController');
});

Route::get('conferences', 'ConferencesController@index')->name('conferences.index');
Route::get('conferences/{id}', 'ConferencesController@show')->name('conferences.show');

// Social logins routes
Route::middleware('social', 'guest')->group(function () {
    Route::get('login/{service}', 'Auth\SocialLoginController@redirect');
    Route::get('login/{service}/callback', 'Auth\SocialLoginController@callback');
});
