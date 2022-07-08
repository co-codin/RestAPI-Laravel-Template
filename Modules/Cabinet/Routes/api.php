<?php

use Illuminate\Support\Facades\Route;
use Modules\Cabinet\Http\Controllers\CabinetController;
use Modules\Cabinet\Http\Controllers\CabinetPageController;

Route::get('/page/cabinets', [CabinetPageController::class, 'index']);
Route::get('/page/cabinets/{cabinet}', [CabinetPageController::class, 'show'])
    ->where('cabinet', '.*');;

Route::resource('cabinets', CabinetController::class)->only(['index', 'show']);
