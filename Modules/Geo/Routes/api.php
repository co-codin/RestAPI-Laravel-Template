<?php

use Modules\Geo\Http\Controllers\GeoController;
use Modules\Geo\Http\Controllers\OrderPointController;

Route::get('/detect-ip', [GeoController::class, 'detectIp'])->name('geo.detect_ip');

Route::resource('order_points', OrderPointController::class)->only(['index', 'show']);
