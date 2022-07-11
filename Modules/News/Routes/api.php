<?php

use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\NewsController;
use Modules\News\Http\Controllers\NewsPageController;

Route::get('page/news', [NewsPageController::class, 'index']);

Route::resource('news', NewsController::class)->only(['index', 'show']);
