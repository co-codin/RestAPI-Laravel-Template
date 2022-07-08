<?php

use Illuminate\Support\Facades\Route;
use Modules\Publication\Http\Controllers\PublicationController;
use Modules\Publication\Http\Controllers\PublicationPageController;

Route::get('/page/publications', [PublicationPageController::class, 'index']);

Route::resource('publications', PublicationController::class)->only(['index', 'show']);
