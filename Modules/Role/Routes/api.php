<?php

use Illuminate\Support\Facades\Route;
use Modules\Role\Http\Controllers\RoleController;

Route::resource('roles', RoleController::class)->only('index', 'show');
