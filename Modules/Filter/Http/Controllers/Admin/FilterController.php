<?php


namespace Modules\Filter\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Filter\Dto\FilterDto;
use Modules\Filter\Http\Requests\FilterCreateRequest;
use Modules\Filter\Http\Requests\FilterSortRequest;
use Modules\Filter\Http\Requests\FilterUpdateRequest;
use Modules\Filter\Http\Resources\FilterResource;
use Modules\Filter\Repositories\FilterRepository;
use Modules\Filter\Services\FilterStorage;

class FilterController extends Controller
{
    public function __construct(
        protected FilterRepository $filterRepository,
        protected FilterStorage $filterStorage
    ) {}

    public function store(FilterCreateRequest $request)
    {
        $filter = $this->filterStorage->store(FilterDto::fromFormRequest($request));

        return new FilterResource($filter);
    }

    public function update(int $filter, FilterUpdateRequest $request)
    {
        $filterModel = $this->filterRepository->find($filter);

        $filterModel = $this->filterStorage->update($filterModel, FilterDto::fromFormRequest($request));

        return new FilterResource($filterModel);
    }

    public function destroy(int $filter)
    {
        $filterModel = $this->filterRepository->find($filter);

        $this->filterStorage->delete($filterModel);

        return response()->noContent();
    }

    public function sort(FilterSortRequest $request)
    {
        $this->filterStorage->sort($request->get('filters'));

        return response()->noContent();
    }
}
