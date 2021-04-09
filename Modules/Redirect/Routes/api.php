<?php

use Illuminate\Support\Facades\Route;
use Modules\Redirect\Http\Controllers\RedirectController;

Route::get('redirects', [RedirectController::class, 'index'])->name('redirects.index');
Route::get('redirects/{old_url}', [RedirectController::class, 'show'])->name('redirects.show');
