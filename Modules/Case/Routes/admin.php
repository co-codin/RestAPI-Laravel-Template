<?php
use Illuminate\Support\Facades\Route;
use Modules\Case\Http\Controllers\Admin\CaseController;

Route::resource('cases', CaseController::class)->except(['index', 'show']);
