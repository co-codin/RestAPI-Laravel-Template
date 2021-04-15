<?php

use Illuminate\Support\Facades\Route;
use Modules\Achievement\Http\Controllers\Admin\AchievementController;

Route::put('achievements/sort', [AchievementController::class, 'sort'])->name('achievements.sort');
Route::resource('achievements', AchievementController::class)->except(['index', 'show']);
