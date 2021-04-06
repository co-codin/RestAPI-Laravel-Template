<?php

namespace Modules\Page\Http\Controllers\Admin;

use App\Repositories\Criteria\ActiveStatusCriteria;
use Illuminate\Routing\Controller;
use Modules\Page\Dto\PageDto;
use Modules\Page\Http\Requests\PageCreateRequest;
use Modules\Page\Http\Requests\PageUpdateRequest;
use Modules\Page\Http\Resources\PageResource;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Services\PageStorage;

class PageController extends Controller
{
    public function __construct(
        protected PageRepository $pageRepository,
        protected PageStorage $pageStorage
    ) {
        $this->pageRepository->popCriteria(ActiveStatusCriteria::class);
    }

    public function index()
    {
        $pages = $this->pageRepository->jsonPaginate();

        return PageResource::collection($pages);
    }

    public function show(int $page)
    {
        $pageModel = $this->pageRepository->find($page);

        return new PageResource($pageModel);
    }

    public function store(PageCreateRequest $request)
    {
        $pageModel = $this->pageStorage->store(PageDto::fromFormRequest($request));

        return new PageResource($pageModel);
    }

    public function update(int $page, PageUpdateRequest $request)
    {
        $pageModel = $this->pageRepository->find($page);

        $pageModel = $this->pageStorage->update($pageModel, (new PageDto($request->validated()))->only(...$request->keys()));

        return new PageResource($pageModel);
    }

    public function destroy(int $page)
    {
        $pageModel = $this->pageRepository->find($page);

        $this->pageStorage->delete($pageModel);

        return response()->noContent();
    }
}
