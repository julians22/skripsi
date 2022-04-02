<?php

use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductCategoryController;
use Tabuna\Breadcrumbs\Trail;

//All route names prefixed with 'admin.'
Route::group(['prefix' => 'product', 'as' => 'product.'], function() {
    Route::get('/', [ProductController::class, 'index'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Home'), route('admin.dashboard'));
            $trail->push(__('All Products'), route('admin.product.index'));
        })
        ->name('index');
    Route::get('/create', [ProductController::class, 'create'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.product.index')->push('Create Product', route('admin.product.create'));
        })
        ->name('create');
    Route::post('/', [ProductController::class, 'store'])
        ->name('store');
});

Route::group(['prefix' => 'category', 'as' => 'category.'], function() {
    Route::get('/', [ProductCategoryController::class, 'index'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Home'), route('admin.dashboard'));
            $trail->push(__('All Product Categories'), route('admin.category.index'));
        })
        ->name('index');
    Route::get('/create', [ProductCategoryController::class, 'create'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.category.index')->push('Create New Product Category', route('admin.category.create'));
        })
        ->name('create');
    Route::post('/', [ProductCategoryController::class, 'store'])->name('store');
});
