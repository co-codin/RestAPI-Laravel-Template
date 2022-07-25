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
        $pages = $this->pageRepository->all();

        return PageResource::collection($pages);
    }

    public function index()
    {
        $pages = $this->pageRepository->jsonPaginate();

        return PageResource::collection($pages);
    }

    public function show(int $page)
    {
        $page = $this->pageRepository->find($page);

        return new PageResource($page);
    }
}
