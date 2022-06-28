<?php

use App\Http\Controllers\Backend\CustomerController;
use App\Models\Customer;
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

    Route::group(['prefix' => '{customer}', 'middleware' => 'role:'.config('boilerplate.access.role.admin')], function() {
        Route::get('edit', [CustomerController::class, 'edit'])
            ->breadcrumbs(function (Trail $trail, Customer $customer) {
                $trail->parent('admin.customer.index');
                $trail->push(__('Edit Customer'), route('admin.customer.edit', $customer));
            })
            ->name('edit');
        Route::get('show', [CustomerController::class, 'show'])
            ->breadcrumbs(function (Trail $trail, Customer $customer) {
                $trail->parent('admin.customer.index');
                $trail->push(__('Show Customer'), route('admin.customer.show', $customer));
            })
            ->name('show');
        Route::patch('/', [CustomerController::class, 'update'])->name('update');
        Route::delete('/', [CustomerController::class, 'destroy'])->name('destroy');
    });
});
