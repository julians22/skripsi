<?php

use App\Http\Controllers\Ajax\CustomerStateController;



Route::get('getCustomers', [CustomerStateController::class, 'getCustomers']);
