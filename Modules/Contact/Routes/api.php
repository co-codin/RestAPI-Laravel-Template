<?php

use Modules\Contact\Http\Controllers\ContactController;
use Modules\Contact\Http\Controllers\ContactPageController;

Route::get('page/contacts', [ContactPageController::class, 'index']);

Route::resource('contacts', ContactController::class)->only(['index', 'show']);
