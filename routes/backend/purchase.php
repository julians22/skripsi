<?php

use App\Http\Controllers\Backend\PurchaseController;
use Tabuna\Breadcrumbs\Trail;

Route::group(['prefix' => 'purchase', 'as' => 'purchase.'], function() {
    Route::get('/', [PurchaseController::class, 'index'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard');
            $trail->push(__('All Purchases'), route('admin.purchase.index'));
        })
        ->name('index');
    Route::get('create', [PurchaseController::class, 'create'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.purchase.index');
            $trail->push(__('Create Purchase'), route('admin.purchase.create'));
        })
        ->name('create');

    Route::group(['prefix' => '{purchase}'], function() {
        Route::get('show', [PurchaseController::class, 'show'])
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.purchase.index');
                $trail->push(__('Show Purchase'), route('admin.purchase.show'));
            })
            ->name('show');
    });
});
