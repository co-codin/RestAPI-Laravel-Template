<?php

use Illuminate\Support\Facades\Route;
use Modules\Property\Http\Controllers\PropertyController;

Route::resource('properties', PropertyController::class)->only(['index', 'show']);
