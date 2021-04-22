<?php

use Illuminate\Support\Facades\Route;
use Modules\Filter\Http\Controllers\FilterController;

Route::resource('filters', FilterController::class)->only(['index', 'show']);
