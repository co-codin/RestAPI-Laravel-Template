<?php

use Illuminate\Support\Facades\Route;
use Modules\Export\Http\Controllers\Admin\ExportController;

Route::resource('exports', ExportController::class)->except(['index', 'show']);
