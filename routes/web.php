<?php

use App\Http\Controllers\AcceptancesController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BiosController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ConferencesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\RejectionController;
use App\Http\Controllers\SubmissionsController;
use App\Http\Controllers\TalksController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * Public
 */
Route::get('/', [HomeController::class, 'show'])->name('home');

Route::get('what-is-this', function () {
    return view('what-is-this');
});

Route::get('speakers', [PublicProfileController::class, 'index'])->name('speakers-public.index');
Route::post('speakers', [PublicProfileController::class, 'search'])->name('speakers-public.search');
Route::get('u/{profileSlug}', [PublicProfileController::class, 'show'])->name('speakers-public.show');
Route::get('u/{profileSlug}/talks/{talkId}', [PublicProfileController::class, 'showTalk'])->name('speakers-public.talks.show');
Route::get('u/{profileSlug}/bios/{bioId}', [PublicProfileController::class, 'showBio'])->name('speakers-public.bios.show');
Route::get('u/{profileSlug}/email', [PublicProfileController::class, 'getEmail'])->name('speakers-public.email');
Route::post('u/{profileSlug}/email', [PublicProfileController::class, 'postEmail'])->name('speakers-public.email.send');

/*
 * App
 */
Route::get('log-out', [Auth\LoginController::class, 'logout'])->name('log-out');

// Disable email registration
Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
    Route::get('account', [AccountController::class, 'show'])->name('account.show');
    Route::get('account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('account/edit', [AccountController::class, 'update']);
    Route::get('account/delete', [AccountController::class, 'delete'])->name('account.delete');
    Route::post('account/delete', [AccountController::class, 'destroy'])->name('account.delete.confirm');
    Route::get('account/export', [AccountController::class, 'export'])->name('account.export');
    Route::get('account/oauth-settings', [AccountController::class, 'oauthSettings'])->name('account.oauth-settings');

    Route::post('acceptances', [AcceptancesController::class, 'store']);
    Route::delete('acceptances/{acceptance}', [AcceptancesController::class, 'destroy']);

    Route::post('rejections', [RejectionController::class, 'store']);
    Route::delete('rejections/{rejection}', [RejectionController::class, 'destroy']);

    Route::post('submissions', [SubmissionsController::class, 'store']);
    Route::delete('submissions/{submission}', [SubmissionsController::class, 'destroy']);

    Route::get('conferences/{id}/favorite', [ConferencesController::class, 'favorite']);
    Route::get('conferences/{id}/unfavorite', [ConferencesController::class, 'unfavorite']);

    Route::get('conferences/{id}/dismiss', [ConferencesController::class, 'dismiss']);
    Route::get('conferences/{id}/undismiss', [ConferencesController::class, 'undismiss']);

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');

    // Necessary for GET-friendly delete because lazy
    Route::get('talks/{id}/delete', [TalksController::class, 'destroy'])->name('talks.delete');
    Route::get('conferences/{id}/delete', [ConferencesController::class, 'destroy'])->name('conferences.delete');
    Route::get('bios/{id}/delete', [BiosController::class, 'destroy'])->name('bios.delete');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('archive', [TalksController::class, 'archiveIndex'])->name('talks.archived.index');
    Route::get('talks/{id}/archive', [TalksController::class, 'archive'])->name('talks.archive');
    Route::get('talks/{id}/restore', [TalksController::class, 'restore'])->name('talks.restore');
    Route::resource('talks', TalksController::class);
    Route::resource('conferences', ConferencesController::class)->except('index', 'show');
    Route::resource('bios', BiosController::class);
});

Route::get('conferences', [ConferencesController::class, 'index'])->name('conferences.index');
Route::get('conferences/{id}', [ConferencesController::class, 'show'])->name('conferences.show');

// Social logins routes
Route::middleware('social', 'guest')->group(function () {
    Route::get('login/{service}', [Auth\SocialLoginController::class, 'redirect']);
    Route::get('login/{service}/callback', [Auth\SocialLoginController::class, 'callback']);
});
