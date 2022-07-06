<?php

namespace Modules\Brand\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Brand\Repositories\BrandRepository;

class BrandPageController extends Controller
{
    public function __construct(
        protected BrandRepository $brandRepository
    ) {}

    public function index()
    {

    }

    public function show(string $brand)
    {

    }
}
