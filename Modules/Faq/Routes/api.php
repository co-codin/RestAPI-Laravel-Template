<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\QuestionController;
use Modules\Faq\Http\Controllers\QuestionCategoryController;

Route::resource('question-categories', QuestionCategoryController::class)->only(['index', 'show']);
Route::resource('questions', QuestionController::class)->only(['index', 'show']);
