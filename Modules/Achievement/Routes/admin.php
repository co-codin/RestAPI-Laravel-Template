<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin'], function () {
    Route::resource('achievements', 'AchievementController');
    Route::post('achievements/modify-positions', 'AchievementController@modifyPosition')->name('achievement.modify-positions');
});
