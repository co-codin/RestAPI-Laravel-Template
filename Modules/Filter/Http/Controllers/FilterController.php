<?php


namespace Modules\Filter\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Filter\Repositories\FilterRepository;

class FilterController extends Controller
{
    public function __construct(
        protected FilterRepository $filterRepository
    ) {}

    public function index()
    {
        
    }

    public function show(int $filter)
    {

    }
}
