<?php

use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\FieldValueController;

Route::post('/upload', UploadController::class)->name('admin.upload');

Route::resource('field-values', FieldValueController::class)
    ->only(['store', 'update', 'destroy']);
