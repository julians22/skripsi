<?php

use App\Http\Controllers\Ajax\CategoryStateController;
use App\Http\Controllers\Ajax\CustomerStateController;
use App\Http\Controllers\Ajax\ProductStateController;
use App\Http\Controllers\Ajax\ReportController;
use App\Http\Controllers\Ajax\SalesStateController;

Route::get('getSuplier', [SuplierStateController::class, 'getSupliers']);
Route::get('getCustomers', [CustomerStateController::class, 'getCustomers']);

Route::get('getProducts', [ProductStateController::class, 'getProducts']);
Route::post('checkProductCode', [ProductStateController::class, 'checkCode']);
Route::get('getProductCode', [ProductStateController::class, 'getProductCode']);

Route::get('getCategories', [CategoryStateController::class, 'getCategories']);

Route::get('getSales', [SalesStateController::class, 'getSales']);

Route::group(['prefix' => 'reports', 'as' => 'reports.'], function() {
    Route::get('{trans}', [ReportController::class, 'report'])
        ->name('trans');
    // Route::get()
});
