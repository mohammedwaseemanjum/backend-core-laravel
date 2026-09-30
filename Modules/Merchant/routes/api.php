<?php

use Illuminate\Support\Facades\Route;
use Modules\Merchant\Http\Controllers\MerchantController;

Route::prefix('merchants')
    ->controller(MerchantController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::post('create', 'create');
        Route::delete('delete', 'delete');
        Route::put('update', 'update');
    });


