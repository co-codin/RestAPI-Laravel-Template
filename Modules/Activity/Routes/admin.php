<?php

use Modules\Activity\Http\Controllers\Admin\ActivityController;

Route::get('activities', [ActivityController::class, 'index'])->name('activities.index');
