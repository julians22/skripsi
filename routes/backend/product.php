<?php

use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Models\Product;
use App\Models\ProductCategory;
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
            $trail->parent('admin.product.index')->push(__('Create New Product'), route('admin.product.create'));
        })
        ->name('create');
    Route::get('/import', [ProductController::class, 'import'])
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.product.index')->push(__('Import Product'), route('admin.product.import'));
        })
        ->name('import');
    Route::post('/', [ProductController::class, 'store'])
        ->name('store');
    Route::group(['prefix' => '{product}'], function() {
        Route::get('/', [ProductController::class, 'show'])
            ->breadcrumbs(function (Trail $trail, Product $product) {
                $trail->parent('admin.product.index');
                $trail->push($product->name, route('admin.product.show', $product));
            })
            ->name('show');
        Route::get('/edit', [ProductController::class, 'edit'])
            ->breadcrumbs(function (Trail $trail, Product $product) {
                $trail->parent('admin.product.index');
                $trail->push($product->name, route('admin.product.edit', $product));
            })
            ->name('edit');
        Route::patch('/', [ProductController::class, 'update'])
            ->name('update');
        Route::delete('/', [ProductController::class, 'destroy'])
            ->name('destroy');
    });
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

    Route::group(['prefix' => '{productCategory}'], function() {
        Route::get('show', [ProductCategoryController::class, 'show'])
            ->breadcrumbs(function (Trail $trail, ProductCategory $productCategory) {
                $trail->parent('admin.category.index');
                $trail->push($productCategory->name, route('admin.category.show', $productCategory));
            })
            ->name('show');
        Route::get('edit', [ProductCategoryController::class, 'edit'])
            ->breadcrumbs(function (Trail $trail, ProductCategory $productCategory) {
                $trail->parent('admin.category.index');
                $trail->push($productCategory->name, route('admin.category.edit', $productCategory));
            })
            ->name('edit');
        Route::patch('/', [ProductCategoryController::class, 'update'])->name('update');
        Route::delete('/', [ProductCategoryController::class, 'destroy'])->name('destroy');
    });
});
