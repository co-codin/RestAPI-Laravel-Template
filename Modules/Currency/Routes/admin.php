<?php

use Illuminate\Support\Facades\Route;
use Modules\Currency\Http\Controllers\Admin\CurrencyController;

Route::resource('currencies', CurrencyController::class)->except(['index', 'show']);
