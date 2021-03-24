<?php

use Illuminate\Support\Facades\Route;
use Modules\Achievement\Http\Controllers\AchievementController;

Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
