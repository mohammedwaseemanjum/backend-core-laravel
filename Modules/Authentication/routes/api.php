<?php

use Illuminate\Support\Facades\Route;
use Modules\Authentication\Http\Controllers\AuthenticationController;

Route::controller(AuthenticationController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});
