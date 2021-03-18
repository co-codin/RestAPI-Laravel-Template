<?php

use Illuminate\Support\Facades\Route;

Route::get('/brands', 'BrandController@index')->name('brands.index');
Route::get('/brands/{brand}', 'BrandController@show')->name('brands.show');
