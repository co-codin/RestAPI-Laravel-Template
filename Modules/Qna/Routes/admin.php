<?php

use Modules\Qna\Http\Controllers\Admin\ProductAnswerController;
use Modules\Qna\Http\Controllers\Admin\ProductQuestionController;

Route::apiResource('product_questions', ProductQuestionController::class)->except(['index', 'show', 'store']);

Route::put('product_questions/{product_question}/approve', [ProductQuestionController::class, 'approve']);
Route::put('product_questions/{product_question}/reject', [ProductQuestionController::class, 'reject']);


Route::apiResource('product_answers', ProductAnswerController::class)->except(['index', 'show']);
