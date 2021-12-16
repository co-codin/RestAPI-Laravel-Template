<?php

use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\FieldValueController;
use App\Http\Controllers\Admin\DocumentGroupController;

Route::post('/upload', UploadController::class)->name('admin.upload');

Route::resource('field-values', FieldValueController::class)
    ->only(['store', 'update', 'destroy']);

Route::resource('document-groups', DocumentGroupController::class)
    ->only(['store']);
