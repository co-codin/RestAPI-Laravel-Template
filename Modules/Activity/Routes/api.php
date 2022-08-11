<?php

use Modules\Activity\Http\Controllers\ActivityController;

Route::get('activities', [ActivityController::class, 'index'])->name('activities.index');
