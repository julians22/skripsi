<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ReportController;
use Tabuna\Breadcrumbs\Trail;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.dashboard'));
    });

Route::group(['prefix' => 'report', 'as' => 'report.'], function() {
    Route::get('/', [ReportController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Home'), route('admin.dashboard'));
            $trail->push(__('Report'), route('admin.report.index'));
        });
    Route::post('sales', [ReportController::class, 'sales'])
        ->name('sales');
});
