<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\QuestionCategoryController;

Route::resource('question_categories', QuestionCategoryController::class);
