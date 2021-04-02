<?php

use Illuminate\Support\Facades\Route;
use Modules\Achievement\Http\Controllers\Admin\AchievementController;

Route::resource('achievements', AchievementController::class);
Route::put('achievements/sort', [AchievementController::class, 'sort'])->name('achievements.sort');
