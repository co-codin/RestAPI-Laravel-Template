<?php

namespace Modules\Page\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Page\Models\Page;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\Admin\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Services\SeoStorage;

class PageSeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
    ) {}

    public function update(SeoUpdateRequest $request, Page $page)
    {
        $this->authorize('update', $page);

        $seo = $this->seoStorage->update(
            $page->seo(),
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}
