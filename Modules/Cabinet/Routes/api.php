<?php

use Illuminate\Support\Facades\Route;
use Modules\Cabinet\Http\Controllers\CabinetController;

Route::resource('cabinets', CabinetController::class)->only(['index', 'show']);
