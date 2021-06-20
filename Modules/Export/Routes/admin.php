<?php

use Illuminate\Support\Facades\Route;
use Modules\Export\Http\Controllers\Admin\ExportController;

Route::post('exports/manually/{export}', [ExportController::class, 'export'])->name('exports.export');
Route::resource('exports', ExportController::class)->except(['index', 'show']);
