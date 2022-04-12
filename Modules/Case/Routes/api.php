<?php

use Illuminate\Support\Facades\Route;
use Modules\Case\Http\Controllers\CaseController;

Route::resource('cases', CaseController::class)->only(['index', 'show']);
