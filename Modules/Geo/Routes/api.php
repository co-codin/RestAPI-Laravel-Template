<?php

use Modules\Geo\Http\Controllers\GeoController;

Route::get('/detect-ip', GeoController::class)->name('geo.detect_ip');
