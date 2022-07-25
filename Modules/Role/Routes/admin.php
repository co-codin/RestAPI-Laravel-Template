<?php

use Modules\Role\Http\Controllers\Admin\PermissionController;
use Modules\Role\Http\Controllers\Admin\RoleController;

Route::apiResource('roles', RoleController::class);

Route::get('permissions/all', [PermissionController::class, 'all']);
Route::apiResource('permissions', PermissionController::class)->only('index', 'show');
