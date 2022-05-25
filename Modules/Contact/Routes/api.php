<?php

use Modules\Contact\Http\Controllers\ContactController;

Route::resource('contacts', ContactController::class)->only('index');
