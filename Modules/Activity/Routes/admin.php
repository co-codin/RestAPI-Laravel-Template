<?php

use Modules\Activity\Http\Controllers\Admin\ActivityController;

//Route::middleware('auth:api')->group(function () {
    Route::match(['get', 'head'], '/activities', [ActivityController::class, 'index'])->name('activities.index');
//});
