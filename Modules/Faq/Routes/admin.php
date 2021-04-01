<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\QuestionCategoryController;
use Modules\Faq\Http\Controllers\Admin\QuestionController;

Route::resource('question_categories', QuestionCategoryController::class);
Route::post('question_categories/sort', [QuestionCategoryController::class, 'sort']);

Route::resource('questions', QuestionController::class);
Route::post('questions/sort', [QuestionController::class, 'sort']);
