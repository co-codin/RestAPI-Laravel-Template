<?php

use Illuminate\Support\Facades\Route;
use Modules\Vacancy\Http\Controllers\Admin\VacancyController;

Route::resource('vacancies', VacancyController::class)->except(['index', 'show']);
