<?php

use Modules\Geo\Http\Controllers\GeoController;
use Modules\Geo\Http\Controllers\OrderPointController;
use Modules\Geo\Http\Controllers\CityController;
use Modules\Geo\Http\Controllers\SoldProductController;

Route::get('/detect-city', [GeoController::class, 'detectCity'])->name('geo.detect_city');

Route::get('cities/all', [CityController::class, 'all'])->name('cities.all');

Route::resource('order-points', OrderPointController::class)->only(['index', 'show']);
Route::resource('cities', CityController::class)->only(['index', 'show']);
Route::resource('sold-products', SoldProductController::class)->only(['index', 'show']);
