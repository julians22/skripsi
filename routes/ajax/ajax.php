<?php

use App\Http\Controllers\Ajax\CategoryStateController;
use App\Http\Controllers\Ajax\CustomerStateController;



Route::get('getCustomers', [CustomerStateController::class, 'getCustomers']);
Route::get('getCategories', [CategoryStateController::class, 'getCategories']);
