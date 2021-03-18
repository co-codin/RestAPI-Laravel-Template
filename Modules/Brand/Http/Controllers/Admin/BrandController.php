<?php


namespace Modules\Brand\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Brand\Services\BrandStorage;

class BrandController extends Controller
{
    protected BrandStorage $brandStorage;

    public function __construct(BrandStorage $brandStorage)
    {
        $this->brandStorage = $brandStorage;
    }

    public function store()
    {

    }
}
