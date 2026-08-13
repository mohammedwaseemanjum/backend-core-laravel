<?php

use Illuminate\Support\Facades\Route;
use Modules\Merchant\Http\Controllers\MerchantController;

Route::middleware(['auth:sanctum'])
    ->prefix('merchants')
    ->controller(MerchantController::class)
    ->group(function () {
        Route::get('test', function () {
            return 1;
        });
    });


