<?php

use App\Http\Controllers\FieldValueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentGroupController;


Route::resource('field-values', FieldValueController::class)
    ->only(['index', 'show']);


Route::resource('document-groups', DocumentGroupController::class)
    ->only(['index']);
