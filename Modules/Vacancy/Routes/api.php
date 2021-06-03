<?php

use Illuminate\Support\Facades\Route;
use Modules\Vacancy\Http\Controllers\VacancyController;

Route::resource('vacancies', VacancyController::class)->only(['index', 'show']);
