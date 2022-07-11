<?php

namespace Modules\Page\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Page\Http\Resources\PagePageResource;
use Modules\Page\Repositories\PageRepository;

class PagePageController extends Controller
{
    public function __construct(
        protected PageRepository $pageRepository
    ) {
        $this->pageRepository->resetCriteria();
    }

    public function show(string $page)
    {
        $page = $this->pageRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect('id', 'name', 'slug', 'full_description')
                    ->with(['seo' => function ($query) {
                        $query->addSelect('seoable_id', 'is_enabled', 'h1', 'title', 'description');
                    }])
                    ;
            })
            ->findByField('slug', $page)
            ->first();

        return new PagePageResource($page);
    }
}
