<?php

use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\Admin\NewsController;


Route::resource('news', NewsController::class);
