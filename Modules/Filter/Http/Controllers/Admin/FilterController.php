<?php


namespace Modules\Filter\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Filter\Dto\FilterDto;
use Modules\Filter\Http\Requests\FilterCreateRequest;
use Modules\Filter\Http\Requests\FilterSortRequest;
use Modules\Filter\Http\Requests\FilterUpdateRequest;
use Modules\Filter\Http\Resources\FilterResource;
use Modules\Filter\Models\Filter;
use Modules\Filter\Repositories\FilterRepository;
use Modules\Filter\Services\FilterStorage;

class FilterController extends Controller
{
    public function __construct(
        protected FilterStorage $filterStorage
    ) {
        $this->authorizeResource(Filter::class, 'filter');
    }

    public function store(FilterCreateRequest $request)
    {
        $filter = $this->filterStorage->store(FilterDto::fromFormRequest($request));

        return new FilterResource($filter);
    }

    public function update(Filter $filter, FilterUpdateRequest $request)
    {
        $filter = $this->filterStorage->update($filter, FilterDto::fromFormRequest($request));

        return new FilterResource($filter);
    }

    public function destroy(Filter $filter)
    {
        $this->filterStorage->delete($filter);

        return response()->noContent();
    }

    public function sort(FilterSortRequest $request)
    {
        $this->filterStorage->sort($request->input('filters'));

        return response()->noContent();
    }
}
