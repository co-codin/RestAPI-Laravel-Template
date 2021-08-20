<?php

use Modules\Geo\Http\Controllers\Admin\OrderPointController;

Route::resource('order-points', OrderPointController::class)->except(['index', 'show']);
