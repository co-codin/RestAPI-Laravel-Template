<?php

namespace Modules\Geo\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Geo\Services\OrderPointStorage;

class OrderPointController extends Controller
{
    public function __construct(
        protected OrderPointStorage $orderPointStorage
    ) {}

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
