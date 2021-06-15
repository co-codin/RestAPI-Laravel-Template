<?php

use Illuminate\Support\Facades\Route;
use Modules\Export\Http\Controllers\Admin\ExportController;

Route::resource('export', ExportController::class)->except(['index', 'show']);
