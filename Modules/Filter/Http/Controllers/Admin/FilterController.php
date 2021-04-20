<?php


namespace Modules\Filter\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Filter\Repositories\FilterRepository;
use Modules\Filter\Services\FilterStorage;

class FilterController extends Controller
{
    public function __construct(
        protected FilterRepository $filterRepository,
        protected FilterStorage $filterStorage
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
