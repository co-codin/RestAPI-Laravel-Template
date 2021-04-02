<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\QuestionCategoryController;

Route::get('/question_categories', [QuestionCategoryController::class, 'index'])->name('question_categories.index');
Route::get('/question_categories/{slug}', [QuestionCategoryController::class, 'show'])->name('question_categories.show');

