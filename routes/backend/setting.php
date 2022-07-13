<?php

use App\Http\Controllers\Global\SettingController;
use Tabuna\Breadcrumbs\Trail;

Route::group(['prefix' => 'settings', 'as' => 'settings.'], function() {
    Route::get('/', [SettingController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Home'), route('admin.dashboard'));
            $trail->push(__('Settings'), route('admin.settings.index'));
        });

    Route::post('/', [SettingController::class, 'updateBulk'])
        ->name('updateBulk');


});

?>
