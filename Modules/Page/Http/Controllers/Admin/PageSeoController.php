<?php

namespace Modules\Page\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Page\Repositories\PageRepository;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\Admin\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Services\SeoStorage;

class PageSeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
        protected PageRepository $pageRepository,
    ) {}

    public function update(SeoUpdateRequest $request, int $page)
    {
        $page = $this->pageRepository->skipCriteria()->find($page);

        $seo = $this->seoStorage->update(
            $page->seo(),
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}
