<?php

namespace Modules\Page\Http\Controllers\Admin;

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
    ) {}

    public function store(PageCreateRequest $request)
    {
        $pageDto = PageDto::fromFormRequest($request);

        if (!$pageDto->assigned_by_id) {
            $pageDto->assigned_by_id = auth('custom-token')->id();
        }

        $pageModel = $this->pageStorage->store($pageDto);

        return new PageResource($pageModel);
    }

    public function update(int $page, PageUpdateRequest $request)
    {
        $pageModel = $this->pageRepository->find($page);

        $pageModel = $this->pageStorage->update($pageModel, PageDto::fromFormRequest($request));

        return new PageResource($pageModel);
    }

    public function destroy(int $page)
    {
        $pageModel = $this->pageRepository->find($page);

        $this->pageStorage->delete($pageModel);

        return response()->noContent();
    }
}
