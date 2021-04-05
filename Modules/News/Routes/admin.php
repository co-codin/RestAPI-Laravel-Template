<?php

use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\Admin\NewsController;
use Modules\News\Http\Controllers\Admin\NewsSeoController;

Route::patch('news/{news}/seo', [NewsSeoController::class, 'update']);

Route::resource('news', NewsController::class);
