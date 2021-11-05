<?php

use App\Http\Controllers\Api\BiosController;
use App\Http\Controllers\Api\ConferencesController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\TalksController;
use App\Http\Controllers\Api\UserBiosController;
use App\Http\Controllers\Api\UserTalksController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('me', [MeController::class, 'index']);
    Route::get('bios/{bioId}', [BiosController::class, 'show']);
    Route::get('user/{userId}/bios', [UserBiosController::class, 'index']);
    Route::get('talks/{talkId}', [TalksController::class, 'show']);
    Route::get('user/{userId}/talks', [UserTalksController::class, 'index']);
    Route::get('conferences/{id}', [ConferencesController::class, 'show']);
    Route::get('conferences', [ConferencesController::class, 'index']);
});
