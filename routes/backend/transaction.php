<?php

use App\Http\Controllers\Backend\TransactionController;
use App\Models\Transaction;
use Tabuna\Breadcrumbs\Trail;


//All route names prefixed with 'admin.'
Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function() {
    Route::get('/', [TransactionController::class, 'index'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard');
            $trail->push(__('All Transactions'), route('admin.transaction.index'));
        })
        ->name('index');
    Route::get('/create', [TransactionController::class, 'create'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.transaction.index');
            $trail->push('Create Transaction', route('admin.transaction.create'));
        })
        ->name('create');

    Route::post('/', [TransactionController::class, 'store'])
        ->name('store');

    Route::group(['prefix' => '{transaction}'], function() {
        Route::get('/show', [TransactionController::class, 'show'])
            ->breadcrumbs(function (Trail $trail, Transaction $transaction) {
                $trail->parent('admin.transaction.index');
                $trail->push('Show Transaction', route('admin.transaction.show', $transaction));
            })
            ->name('show');
        Route::get('/edit', [TransactionController::class, 'edit'])
            ->breadcrumbs(function (Trail $trail, Transaction $transaction) {
                $trail->parent('admin.transaction.index');
                $trail->push('Edit Transaction', route('admin.transaction.edit', $transaction));
            })
            ->name('edit');
        Route::get('print', [TransactionController::class, 'print'])
            ->name('print');
    });
});
