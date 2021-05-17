<?php

use Illuminate\Support\Facades\Route;
use Modules\Attribute\Http\Controllers\AttributeController;

Route::resource('attributes', AttributeController::class)->only(['index', 'show']);
