<?php

use Illuminate\Support\Facades\Route;
use Modules\Cabinet\Http\Controllers\Admin\CabinetController;
use Modules\Cabinet\Http\Controllers\Admin\CabinetSeoController;

Route::patch('cabinets/{cabinet}/seo', [CabinetSeoController::class, 'update']);

Route::resource('cabinets', CabinetController::class)->except('index', 'show');
