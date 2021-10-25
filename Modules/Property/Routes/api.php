<?php

use Illuminate\Support\Facades\Route;
use Modules\Property\Http\Controllers\PropertyController;

Route::get('properties/all', [PropertyController::class, 'all'])->name('properties.all');
Route::resource('properties', PropertyController::class)->only(['index', 'show']);
