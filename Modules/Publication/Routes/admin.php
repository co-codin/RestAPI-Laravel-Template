<?php

use Illuminate\Support\Facades\Route;
use Modules\Publication\Http\Controllers\Admin\PublicationController;

Route::resource('publications', PublicationController::class);
