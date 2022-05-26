<?php

use Modules\Contact\Http\Controllers\Admin\ContactController;

Route::put('contacts/sort', [ContactController::class, 'sort'])->name('contacts.sort');
Route::resource('contacts', ContactController::class)->except('index', 'show');
