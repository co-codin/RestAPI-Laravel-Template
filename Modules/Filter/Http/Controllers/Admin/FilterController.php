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
        protected FilterStorage $filterStorage,
        protected FilterRepository $filterRepository
    ) {}

    public function store(FilterCreateRequest $request)
    {
        $this->authorize('create', Filter::class);

        $filter = $this->filterStorage->store(FilterDto::fromFormRequest($request));

        return new FilterResource($filter);
    }

    public function update(int $filter, FilterUpdateRequest $request)
    {
        $filter = $this->filterRepository->find($filter);

        $this->authorize('update', $filter);

        $filter = $this->filterStorage->update($filter, FilterDto::fromFormRequest($request));

        return new FilterResource($filter);
    }

    public function destroy(int $filter)
    {
        $filter = $this->filterRepository->find($filter);

        $this->authorize('delete', $filter);

        $this->filterStorage->delete($filter);

        return response()->noContent();
    }

    public function sort(FilterSortRequest $request)
    {
        $this->authorize('sort', Filter::class);

        $this->filterStorage->sort($request->input('filters'));

        return response()->noContent();
    }
}
