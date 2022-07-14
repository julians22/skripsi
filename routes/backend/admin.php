<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ReportController;
use Tabuna\Breadcrumbs\Trail;
use Codedge\Updater\UpdaterManager;

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

Route::get('updater', function (UpdaterManager $updater) {
    // Check if new version is available
    if($updater->source()->isNewVersionAvailable()) {

        // Get the current installed version
        echo $updater->source()->getVersionInstalled();

        // Get the new version available
        $versionAvailable = $updater->source()->getVersionAvailable();

        // Create a release
        $release = $updater->source()->fetch($versionAvailable);

        // Run the update process
        $updater->source()->update($release);

    } else {
        echo "No new version available.";
    }

});
