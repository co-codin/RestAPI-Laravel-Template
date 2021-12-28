<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\QuestionController;
use Modules\Faq\Http\Controllers\QuestionCategoryController;

Route::get('question-categories/all', [QuestionCategoryController::class, 'all'])->name('question-categories.all');
Route::resource('question-categories', QuestionCategoryController::class)->only(['index', 'show']);
Route::resource('questions', QuestionController::class)->only(['index', 'show']);
