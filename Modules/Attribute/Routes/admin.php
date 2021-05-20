<?php

use Illuminate\Support\Facades\Route;
use Modules\Attribute\Http\Controllers\Admin\AttributeController;

Route::resource('attributes', AttributeController::class)->except(['index', 'show']);

