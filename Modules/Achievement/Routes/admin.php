<?php

use Illuminate\Support\Facades\Route;
use Modules\Achievement\Http\Controllers\Admin\AchievementController;

Route::resource('achievements', AchievementController::class);
Route::post('achievements/modify-positions', [AchievementController::class, 'modifyPosition'])->name('achievements.modify-positions');
