<?php


namespace Modules\News\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\News\Dto\NewsDto;
use Modules\News\Http\Requests\NewsCreateRequest;
use Modules\News\Http\Requests\NewsUpdateRequest;
use Modules\News\Http\Resources\NewsResource;
use Modules\News\Models\News;
use Modules\News\Repositories\NewsRepository;
use Modules\News\Services\NewsStorage;

class NewsController extends Controller
{
    public function __construct(
        protected NewsStorage $newsStorage,
        protected NewsRepository $newsRepository
    ) {}

    public function store(NewsCreateRequest $request)
    {
        $this->authorize('create', News::class);

        $newsDto = NewsDto::fromFormRequest($request);

        if (!$newsDto->assigned_by_id) {
            $newsDto->assigned_by_id = auth('sanctum')->id();
        }

        $news = $this->newsStorage->store($newsDto);

        return new NewsResource($news);
    }

    public function update(int $news, NewsUpdateRequest $request)
    {
        $news = $this->newsRepository->find($news);

        $this->authorize('update', $news);

        $news = $this->newsStorage->update($news, NewsDto::fromFormRequest($request));

        return new NewsResource($news);
    }

    public function destroy(int $news)
    {
        $news = $this->newsRepository->find($news);

        $this->authorize('delete', $news);

        $this->newsStorage->delete($news);

        return response()->noContent();
    }
}
