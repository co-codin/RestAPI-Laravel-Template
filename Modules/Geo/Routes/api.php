<?php

use Modules\Geo\Http\Controllers\GeoController;
use Modules\Geo\Http\Controllers\OrderPointController;
use Modules\Geo\Http\Controllers\CityController;
use Modules\Geo\Http\Controllers\SoldProductController;
use Modules\Geo\Http\Controllers\CityPageController;

Route::get('/detect-city', [GeoController::class, 'detectCity'])->name('geo.detect_city');


Route::group(['prefix' => 'page'], function () {
    Route::get('/cities_with_order_point', [CityPageController::class, 'citiesWithOrderPoint']);
});


Route::resource('order-points', OrderPointController::class)->only(['index', 'show']);
Route::resource('cities', CityController::class)->only(['index', 'show']);
Route::resource('sold-products', SoldProductController::class)->only(['index', 'show']);
