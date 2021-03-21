<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin'], function () {
    Route::post('achievements', 'AchievementController@store')->name('achievement.store');
    Route::patch('achievements/{achievementId}', 'AchievementController@update')->name('achievement.update');
    Route::delete('achievements/{achievementId}', 'AchievementController@destroy')->name('achievement.delete');
    Route::post('achievements/modify-positions', 'AchievementController@modifyPosition')->name('achievement.modify-positions');
});
