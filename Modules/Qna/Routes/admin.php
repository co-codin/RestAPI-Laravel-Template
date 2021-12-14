<?php

use Modules\Qna\Http\Controllers\Admin\QuestionController;

Route::apiResource('questions', QuestionController::class)->except(['index', 'show', 'store']);

Route::put('questions/{question}/approve', [QuestionController::class, 'approve']);
Route::put('questions/{question}/reject', [QuestionController::class, 'reject']);


Route::apiResource('answers', QuestionController::class)->except(['index', 'show']);
