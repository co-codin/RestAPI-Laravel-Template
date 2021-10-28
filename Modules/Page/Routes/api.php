<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\PageController;

Route::get('pages/all', [PageController::class, 'all'])->name('pages.all');
Route::resource('pages', PageController::class)->only(['index', 'show']);
