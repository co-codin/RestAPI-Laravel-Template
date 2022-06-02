<?php

use Illuminate\Support\Facades\Route;
use Modules\Case\Http\Controllers\CaseController;

Route::resource('case_models', CaseController::class)->only(['index', 'show']);
