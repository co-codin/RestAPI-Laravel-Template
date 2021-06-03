<?php

use Illuminate\Support\Facades\Route;
use Modules\Vacancy\Http\Controllers\VacancyController;

Route::resource('achievements', VacancyController::class)->only(['index', 'show']);
