<?php

use Illuminate\Support\Facades\Route;

Route::resource('achievements', 'AchievementController');
Route::post('achievements/modify-positions', 'AchievementController@modifyPosition')->name('achievement.modify-positions');
