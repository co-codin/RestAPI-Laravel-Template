<?php

use Illuminate\Support\Facades\Route;
use Modules\Currency\Http\Controllers\CurrencyController;

Route::resource('currencies', CurrencyController::class)->only(['index', 'show']);
