<?php

use Modules\Geo\Http\Controllers\GeoController;
use Modules\Geo\Http\Controllers\OrderPointController;
use Modules\Geo\Http\Controllers\CityController;

Route::get('/detect-ip', [GeoController::class, 'detectIp'])->name('geo.detect_ip');

Route::resource('order_points', OrderPointController::class)->only(['index', 'show']);
Route::resource('cities', CityController::class)->only(['index', 'show']);
