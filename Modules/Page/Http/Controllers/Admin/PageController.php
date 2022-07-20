<?php

namespace Modules\Page\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Page\Dto\PageDto;
use Modules\Page\Http\Requests\PageCreateRequest;
use Modules\Page\Http\Requests\PageUpdateRequest;
use Modules\Page\Http\Resources\PageResource;
use Modules\Page\Models\Page;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Services\PageStorage;

class PageController extends Controller
{
    public function __construct(
        protected PageStorage $pageStorage,
        protected PageRepository $pageRepository
    ) {}

    public function store(PageCreateRequest $request)
    {
        $this->authorize('create', Page::class);

        $pageDto = PageDto::fromFormRequest($request);

        if (!$pageDto->assigned_by_id) {
            $pageDto->assigned_by_id = auth('sanctum')->id();
        }

        $pageModel = $this->pageStorage->store($pageDto);

        return new PageResource($pageModel);
    }

    public function update(int $page, PageUpdateRequest $request)
    {
        $page = $this->pageRepository->find($page);

        $this->authorize('update', $page);

        $page = $this->pageStorage->update($page, PageDto::fromFormRequest($request));

        return new PageResource($page);
    }

    public function destroy(int $page)
    {
        $page = $this->pageRepository->find($page);

        $this->authorize('delete', $page);

        $this->pageStorage->delete($page);

        return response()->noContent();
    }
}
