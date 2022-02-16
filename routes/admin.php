<?php

use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\FieldValueController;
use App\Http\Controllers\Admin\DocumentGroupController;
use App\Http\Controllers\Admin\SearchController;
use Illuminate\Support\Facades\Route;

Route::post('/upload', UploadController::class)->name('admin.upload');

Route::resource('field-values', FieldValueController::class)
    ->only(['store', 'update', 'destroy']);

Route::resource('document-groups', DocumentGroupController::class)
    ->only(['store']);

Route::get('global-search', SearchController::class)->name('admin.search');
