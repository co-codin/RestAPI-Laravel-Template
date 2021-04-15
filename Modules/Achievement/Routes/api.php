<?php

use Illuminate\Support\Facades\Route;
use Modules\Achievement\Http\Controllers\AchievementController;

Route::resource('achievements', AchievementController::class)->only(['index', 'show']);
