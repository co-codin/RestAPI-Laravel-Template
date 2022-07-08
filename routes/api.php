<?php

use App\Http\Controllers\EnumController;
use App\Http\Controllers\FieldValueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentGroupController;
use Nwidart\Modules\Facades\Module;


Route::resource('field-values', FieldValueController::class)
    ->only(['index', 'show']);


Route::resource('document-groups', DocumentGroupController::class)
    ->only(['index']);

Route::get('/enums', [EnumController::class, 'index']);
