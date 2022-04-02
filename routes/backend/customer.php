<?php

use App\Http\Controllers\Backend\CustomerController;
use Tabuna\Breadcrumbs\Trail;

Route::group(['prefix' => 'customer', 'as' => 'customer.'], function() {
    Route::get('/', [CustomerController::class, 'index'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Home'), route('admin.dashboard'));
            $trail->push(__('All Customers'), route('admin.customer.index'));
        })
        ->name('index');

    Route::get('/create', [CustomerController::class, 'create'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.customer.index');
            $trail->push(__('Create Customer'), route('admin.customer.create'));
        })
        ->name('create');

    Route::post('/', [CustomerController::class, 'store'])->name('store');
});
