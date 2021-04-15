<?php

use Illuminate\Support\Facades\Route;
use Modules\Redirect\Http\Controllers\RedirectController;

Route::resource('redirects', RedirectController::class)->only(['index', 'show']);
