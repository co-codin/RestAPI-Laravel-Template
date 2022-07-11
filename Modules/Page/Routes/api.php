<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\PageController;
use Modules\Page\Http\Controllers\PagePageController;

Route::get('page/pages/{page}', [PagePageController::class, 'show']);

Route::get('pages/all', [PageController::class, 'all'])->name('pages.all');
Route::resource('pages', PageController::class)->only(['index', 'show']);
