<?php

use App\Http\Controllers\EnumController;
use App\Http\Controllers\FieldValueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentGroupController;
use App\Http\Controllers\HomePageController;

Route::resource('field-values', FieldValueController::class)
    ->only(['index', 'show']);


Route::resource('document-groups', DocumentGroupController::class)
    ->only(['index']);

Route::get('/enums', [EnumController::class, 'index']);

Route::get('/page/home', [HomePageController::class, 'index']);
