<?php

use Illuminate\Support\Facades\Route;
use Modules\Vacancy\Http\Controllers\VacancyController;
use Modules\Vacancy\Http\Controllers\VacancyPageController;


Route::get('/page/vacancies', [VacancyPageController::class, 'index']);
Route::get('/page/vacancies/{vacancy}', [VacancyPageController::class, 'show'])
    ->where('vacancy', '.*');;

Route::resource('vacancies', VacancyController::class)->only(['index', 'show']);
