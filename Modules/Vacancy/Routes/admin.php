<?php

use Illuminate\Support\Facades\Route;
use Modules\Vacancy\Http\Controllers\Admin\VacancyController;

Route::resource('achievements', VacancyController::class)->except(['index', 'show']);
