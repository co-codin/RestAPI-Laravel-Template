<?php

use App\Http\Controllers\Admin\UploadController;

Route::post('/upload', UploadController::class)->name('admin.upload');
