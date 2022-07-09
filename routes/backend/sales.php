<?php

use App\Http\Controllers\Backend\SalesController;
use App\Models\Sales;
use Tabuna\Breadcrumbs\Trail;


//All route names prefixed with 'admin.'
Route::group(['prefix' => 'sales', 'as' => 'sales.'], function() {
    Route::get('/', [SalesController::class, 'index'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard');
            $trail->push(__('All Sales'), route('admin.sales.index'));
        })
        ->name('index');
    Route::get('/create', [SalesController::class, 'create'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.sales.index');
            $trail->push(__('Add Sales'), route('admin.sales.create'));
        })
        ->name('create');

    Route::post('/', [SalesController::class, 'store'])
        ->name('store');

    Route::group(['prefix' => '{sales}'], function() {
        Route::get('/show', [SalesController::class, 'show'])
            ->breadcrumbs(function (Trail $trail, Sales $sales) {
                $trail->parent('admin.sales.index');
                $trail->push(__('Show Sales'), route('admin.sales.show', $sales));
            })
            ->name('show');
        Route::get('/edit', [SalesController::class, 'edit'])
            ->breadcrumbs(function (Trail $trail, Sales $sales) {
                $trail->parent('admin.sales.index');
                $trail->push(__('Edit Sales'), route('admin.sales.edit', $sales));
            })
            ->name('edit');

        Route::get('print', [SalesController::class, 'print'])
            ->name('print');

        Route::delete('/', [SalesController::class, 'destroy'])
            ->name('destroy');

        Route::group(['prefix' => 'payment', 'as' => 'payment.'], function() {
            Route::post('/', [SalesController::class, 'storePayment'])
                ->name('store');
        });
    });
});
