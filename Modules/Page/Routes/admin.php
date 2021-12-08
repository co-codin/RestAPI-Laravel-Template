<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\Admin\PageController;
use Modules\Page\Http\Controllers\Admin\PageSeoController;

Route::patch('pages/{page}/seo', [PageSeoController::class, 'update']);

Route::resource('pages', PageController::class)->except(['index', 'show']);
