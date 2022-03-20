<?php

use App\Http\Controllers\Backend\TransactionController;
use Tabuna\Breadcrumbs\Trail;


//All route names prefixed with 'admin.'
Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function() {
    Route::get('/', [TransactionController::class, 'index'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Home'), route('admin.dashboard'));
            $trail->push(__('All Transactions'), route('admin.transaction.index'));
        })
        ->name('index');
    Route::get('/create', [TransactionController::class, 'create'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.transaction.index')->push('Create Transaction', route('admin.transaction.create'));
        })
        ->name('create');

    Route::post('/', [TransactionController::class, 'store'])
        ->name('store');
});
