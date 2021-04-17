<?php

use Illuminate\Support\Facades\Route;
use Modules\Property\Http\Controllers\Admin\PropertyController;

Route::resource('properties', PropertyController::class)->except(['index', 'show']);
