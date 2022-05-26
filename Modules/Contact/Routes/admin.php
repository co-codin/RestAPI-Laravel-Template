<?php

use Modules\Contact\Http\Controllers\Admin\ContactController;

Route::resource('contacts', ContactController::class)->except('index', 'show');
