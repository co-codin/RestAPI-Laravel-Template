<?php

use Illuminate\Support\Facades\Route;
use Modules\Publication\Http\Controllers\PublicationController;

Route::resource('publications', PublicationController::class)->only(['index', 'show']);
