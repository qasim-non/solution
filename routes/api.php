<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::post('/request', [CustomerController::class, 'request']);

Route::post('/message', [CustomerController::class, 'message']);

Route::post('/login', [AdminController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {

    Route::get('/system-types', [AdminController::class, 'systemTypes']);

    Route::get('/dashboard', [AdminController::class, 'dashboardInfo']);

    Route::get('/requests', [AdminController::class, 'returnAllRequests']);

    Route::get('/request/social-media-account/{request}', [AdminController::class, 'returnSocialMediaAccount']);

    Route::get('/messages', [AdminController::class, 'returnAllMessages']);

    Route::patch('/request/{request}/complete', [AdminController::class, 'requestComplete']);

    Route::patch('/request/{request}/revert', [AdminController::class, 'requestRevert']);

});


