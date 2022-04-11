<?php

use Illuminate\Support\Facades\Route;
use Modules\Currency\Http\Controllers\CurrencyController;

Route::get('/currencies/{currency}/rate', [CurrencyController::class, 'rate']);

Route::resource('currencies', CurrencyController::class)->only(['index', 'show']);
