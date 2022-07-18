<?php

namespace Modules\Page\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Page\Http\Resources\PageResource;
use Modules\Page\Models\Page;
use Modules\Page\Repositories\PageRepository;

class PageController extends Controller
{
    public function __construct(
        protected PageRepository $pageRepository
    ) {
        $this->authorizeResource(Page::class, 'page');
    }

    public function all()
    {
        $this->authorize('viewAny', Page::class);

        $pages = $this->pageRepository->all();

        return PageResource::collection($pages);
    }

    public function index()
    {
        $pages = $this->pageRepository->jsonPaginate();

        return PageResource::collection($pages);
    }

    public function show(Page $page)
    {
        return new PageResource($page);
    }
}
