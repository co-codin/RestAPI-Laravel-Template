<?php

use Illuminate\Support\Facades\Route;

Route::post('/brands', 'BrandController@store')->name('brands.store');
Route::patch('/brands/{brand}', 'BrandController@update')->name('brands.update');
Route::delete('/brands/{brand}', 'BrandController@destroy')->name('brands.delete');
