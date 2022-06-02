<?php
use Illuminate\Support\Facades\Route;
use Modules\Case\Http\Controllers\Admin\CaseController;

Route::resource('case_models', CaseController::class)->except(['index', 'show']);
