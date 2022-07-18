<?php


namespace Modules\News\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\News\Dto\NewsDto;
use Modules\News\Http\Requests\NewsCreateRequest;
use Modules\News\Http\Requests\NewsUpdateRequest;
use Modules\News\Http\Resources\NewsResource;
use Modules\News\Models\News;
use Modules\News\Services\NewsStorage;

class NewsController extends Controller
{
    public function __construct(
        protected NewsStorage $newsStorage
    ) {
        $this->authorizeResource(News::class, 'news');
    }

    public function store(NewsCreateRequest $request)
    {
        $newsDto = NewsDto::fromFormRequest($request);

        if (!$newsDto->assigned_by_id) {
            $newsDto->assigned_by_id = auth('sanctum')->id();
        }

        $news = $this->newsStorage->store($newsDto);

        return new NewsResource($news);
    }

    public function update(News $news, NewsUpdateRequest $request)
    {
        $news = $this->newsStorage->update($news, NewsDto::fromFormRequest($request));

        return new NewsResource($news);
    }

    public function destroy(News $news)
    {
        $this->newsStorage->delete($news);

        return response()->noContent();
    }
}
