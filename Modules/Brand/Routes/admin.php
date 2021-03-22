<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin'], function () {
    Route::resource('brands', 'BrandController');
});
