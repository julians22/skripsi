<?php

use App\Http\Controllers\Ajax\CategoryStateController;
use App\Http\Controllers\Ajax\CustomerStateController;
use App\Http\Controllers\Ajax\ProductStateController;

Route::get('getCustomers', [CustomerStateController::class, 'getCustomers']);
Route::get('getProducts', [ProductStateController::class, 'getProducts']);
Route::get('getCategories', [CategoryStateController::class, 'getCategories']);
