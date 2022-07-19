<?php

namespace Modules\Page\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Page\Dto\PageDto;
use Modules\Page\Http\Requests\PageCreateRequest;
use Modules\Page\Http\Requests\PageUpdateRequest;
use Modules\Page\Http\Resources\PageResource;
use Modules\Page\Models\Page;
use Modules\Page\Services\PageStorage;

class PageController extends Controller
{
    public function __construct(
        protected PageStorage $pageStorage
    ) {
        $this->authorizeResource(Page::class, 'page');
    }

    public function store(PageCreateRequest $request)
    {
        $pageDto = PageDto::fromFormRequest($request);

        if (!$pageDto->assigned_by_id) {
            $pageDto->assigned_by_id = auth('sanctum')->id();
        }

        $pageModel = $this->pageStorage->store($pageDto);

        return new PageResource($pageModel);
    }

    public function update(Page $page, PageUpdateRequest $request)
    {
        $page = $this->pageStorage->update($page, PageDto::fromFormRequest($request));

        return new PageResource($page);
    }

    public function destroy(Page $page)
    {
        $this->pageStorage->delete($page);

        return response()->noContent();
    }
}
