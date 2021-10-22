<?php


namespace Modules\News\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\News\Dto\NewsDto;
use Modules\News\Http\Requests\NewsCreateRequest;
use Modules\News\Http\Requests\NewsUpdateRequest;
use Modules\News\Http\Resources\NewsResource;
use Modules\News\Repositories\NewsRepository;
use Modules\News\Services\NewsStorage;

class NewsController extends Controller
{
    public function __construct(
        protected NewsRepository $newsRepository,
        protected NewsStorage $newsStorage
    ) {}

    public function store(NewsCreateRequest $request)
    {
        $newsDto = NewsDto::fromFormRequest($request);

        if (!$newsDto->assigned_by_id) {
            $newsDto->assigned_by_id = auth('api')->id();
        }

        $news = $this->newsStorage->store($newsDto);

        return new NewsResource($news);
    }

    public function update(int $news, NewsUpdateRequest $request)
    {
        $newsModel = $this->newsRepository->find($news);

        $newsModel = $this->newsStorage->update($newsModel, NewsDto::fromFormRequest($request));

        return new NewsResource($newsModel);
    }

    public function destroy(int $news)
    {
        $newsModel = $this->newsRepository->find($news);

        $this->newsStorage->delete($newsModel);

        return response()->noContent();
    }
}
