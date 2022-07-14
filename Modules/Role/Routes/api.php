<?php

use Illuminate\Support\Facades\Route;
use Modules\Role\Http\Controllers\RoleController;
use Modules\Role\Http\Controllers\PermissionController;

Route::resource('roles', RoleController::class)->only('index', 'show');
Route::resource('permissions', PermissionController::class)->only('index', 'show');
