<?php

namespace Modules\Page\Http\Controllers\Admin;

use App\Repositories\Criteria\ActiveStatusCriteria;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Http\Resources\PageResource;
use Modules\Page\Repositories\PageRepository;

class PageController extends Controller
{
    public function __construct(
        protected PageRepository $pageRepository
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
}
