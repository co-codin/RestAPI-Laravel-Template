<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\PageController;

Route::resource('pages', PageController::class)->only(['index', 'show']);
