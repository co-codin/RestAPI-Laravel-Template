<?php

use Modules\Role\Http\Controllers\Admin\RoleController;

Route::resource('roles', RoleController::class)->except('index', 'show');
