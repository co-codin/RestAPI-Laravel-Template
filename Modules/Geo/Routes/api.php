<?php

use Modules\Geo\Http\Controllers\GeoController;

Route::get('/detect-ip', [GeoController::class, 'detectIp'])->name('geo.detect_ip');
