<?php

use Modules\Client\Http\Controllers\Admin\ClientBanController;

Route::group(['prefix' => 'clients'], function () {
    Route::patch('{client}/ban', [ClientBanController::class, 'ban'])->name('client.ban');
    Route::patch('{client}/unban', [ClientBanController::class, 'unban'])->name('client.unban');
});
