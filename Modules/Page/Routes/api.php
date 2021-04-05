<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\PageController;

Route::get('pages', [PageController::class, 'index'])->name('pages.index');
Route::get('pages/{slug}', [PageController::class, 'show'])->name('pages.show');
