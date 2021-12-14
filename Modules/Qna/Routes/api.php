<?php

use Modules\Qna\Http\Controllers\ProductAnswerRateController;
use Modules\Qna\Http\Controllers\ProductAnswerController;
use Modules\Qna\Http\Controllers\ProductQuestionController;
use Modules\Qna\Http\Middleware\ProductAnswerRateMiddleware;

Route::apiResource('product_questions', ProductQuestionController::class)
    ->only('index', 'show', 'store');

Route::apiResource('product_answers', ProductAnswerController::class)
    ->only('index', 'show');

Route::middleware(ProductAnswerRateMiddleware::class)->group(function () {
    Route::match(['put', 'patch'], 'product_answers-rate/{product_answer}', [ProductAnswerRateController::class, 'rate']);
});
