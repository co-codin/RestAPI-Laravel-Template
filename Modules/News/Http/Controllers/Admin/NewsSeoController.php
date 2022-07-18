<?php


namespace Modules\News\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\News\Models\News;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\Admin\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Services\SeoStorage;

class NewsSeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
    ) {}

    public function update(SeoUpdateRequest $request, News $news)
    {
        $this->authorize('update', $news);

        $seo = $this->seoStorage->update(
            $news->seo(),
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}
