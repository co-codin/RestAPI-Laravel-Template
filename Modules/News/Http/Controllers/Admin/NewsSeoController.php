<?php


namespace Modules\News\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\News\Repositories\NewsRepository;
use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Http\Requests\SeoUpdateRequest;
use Modules\Seo\Http\Resources\SeoResource;
use Modules\Seo\Services\SeoStorage;

class NewsSeoController extends Controller
{
    public function __construct(
        protected SeoStorage $seoStorage,
        protected NewsRepository $newsRepository,
    ) {}

    public function update(SeoUpdateRequest $request, int $news)
    {
        $brand = $this->newsRepository->skipCriteria()->find($news);

        $seo = $this->seoStorage->update(
            $brand->seo(),
            new SeoDto($request->validated())
        );

        return new SeoResource($seo);
    }
}
