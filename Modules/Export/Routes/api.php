<?php

use Illuminate\Support\Facades\Route;
use Modules\Export\Http\Controllers\ExportController;

Route::resource('export', ExportController::class)->only(['index', 'show']);
