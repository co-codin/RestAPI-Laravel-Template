<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\Admin\QuestionCategoryController;
use Modules\Faq\Http\Controllers\Admin\QuestionController;

Route::post('question-categories/sort', [QuestionCategoryController::class, 'sort']);
Route::resource('question-categories', QuestionCategoryController::class)->except(['index', 'show']);

Route::post('questions/sort', [QuestionController::class, 'sort']);
Route::resource('questions', QuestionController::class)->except(['index', 'show']);
