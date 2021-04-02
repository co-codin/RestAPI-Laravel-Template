<?php

use Illuminate\Support\Facades\Route;
use Modules\Publication\Http\Controllers\PublicationController;

Route::get('publications', [PublicationController::class, 'index'])->name('publications.index');
Route::get('publications/{slug}', [PublicationController::class, 'show'])->name('publications.show');
