<?php

use Illuminate\Support\Facades\Route;
use Modules\Merchant\Http\Controllers\MerchantController;

Route::prefix('merchants')
    ->controller(MerchantController::class)
    ->group(function () {
        Route::get('/', function () {
            return 1;
        });
        // Route::post('upload', 'upload');
        // Route::post('delete', 'delete');
        // Route::post('update', 'update');
    });


