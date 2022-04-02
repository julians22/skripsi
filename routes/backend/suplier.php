<?php

use App\Http\Controllers\Backend\SupplierController;

Route::group(['prefix' => 'supplier', 'as' => 'supplier.'], function() {
    Route::get('/', [SupplierController::class, 'index'])
        ->breadcrumbs(function ($trail) {
            $trail->push(__('Home'), route('admin.dashboard'));
            $trail->push(__('All Suppliers'), route('admin.supplier.index'));
        })
        ->name('index');

    Route::get('/create', [SupplierController::class, 'create'])
        ->breadcrumbs(function ($trail) {
            $trail->parent('admin.supplier.index');
            $trail->push(__('Create supplier'), route('admin.supplier.create'));
        })
        ->name('create');

    Route::post('/', [SupplierController::class, 'store'])->name('store');
});
