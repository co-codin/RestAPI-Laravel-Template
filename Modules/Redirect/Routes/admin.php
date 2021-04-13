<?php

use Illuminate\Support\Facades\Route;
use Modules\Redirect\Http\Controllers\Admin\RedirectController;

Route::resource('redirects', RedirectController::class)->except(['index', 'show']);
