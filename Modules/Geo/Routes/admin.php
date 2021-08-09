<?php

use Modules\Geo\Http\Controllers\Admin\OrderPointController;

Route::resource('order_points', OrderPointController::class)->except(['index', 'show']);
