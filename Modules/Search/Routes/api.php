<?php

use Modules\Search\Http\Controllers\SearchController;

Route::prefix('search')->group(function() {
    Route::get('/', [SearchController::class, 'index'])->name('search');

    Route::post('/live', [SearchController::class, 'live'])
        ->name('search-live');
});
