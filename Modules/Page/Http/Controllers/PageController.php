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
    ) {}

    public function all()
    {
        $this->authorize('viewAny', Page::class);

        $pages = $this->pageRepository->all();

        return PageResource::collection($pages);
    }

    public function index()
    {
        $this->authorize('viewAny', Page::class);

        $pages = $this->pageRepository->jsonPaginate();

        return PageResource::collection($pages);
    }

    public function show(int $page)
    {
        $page = $this->pageRepository->find($page);

        $this->authorize('view', $page);

        return new PageResource($page);
    }
}
