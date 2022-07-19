<?php


namespace Modules\Filter\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Filter\Http\Resources\FilterResource;
use Modules\Filter\Models\Filter;
use Modules\Filter\Repositories\FilterRepository;

class FilterController extends Controller
{
    public function __construct(
        protected FilterRepository $filterRepository
    ) {
        $this->authorizeResource(Filter::class, 'filter');
    }

    public function index()
    {
        $filters = $this->filterRepository->jsonPaginate();

        return FilterResource::collection($filters);
    }

    public function show(Filter $filter)
    {
        return new FilterResource($filter);
    }
}
