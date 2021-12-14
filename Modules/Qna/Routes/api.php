<?php

use Modules\Qna\Http\Controllers\AnswerRateController;
use Modules\Qna\Http\Controllers\QuestionController;
use Modules\Qna\Http\Middleware\AnswerRateMiddleware;

Route::apiResource('questions', QuestionController::class)
    ->only('index', 'show', 'store');

Route::apiResource('questions', QuestionController::class)
    ->only('index', 'show');

Route::middleware(AnswerRateMiddleware::class)->group(function () {
    Route::match(['put', 'patch'], 'answers-rate/{answer}', [AnswerRateController::class, 'rate']);
});
