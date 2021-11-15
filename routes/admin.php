<?php

use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\FieldValueController;

Route::post('/upload', UploadController::class)->name('admin.upload');

Route::post('/field-values', [FieldValueController::class, 'store'])->name('field-values.store');
