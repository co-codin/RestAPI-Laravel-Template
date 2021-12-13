<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\News\Http\Resources\NewsResource;
use Modules\News\Jobs\UpdateViewJob;
use Modules\News\Repositories\NewsRepository;

class NewsController extends Controller
{
    public function __construct(
        protected NewsRepository $newsRepository
    ) {}

    public function index()
    {
        $news = $this->newsRepository->jsonPaginate();

        return NewsResource::collection($news);
    }

    public function show(int $news)
    {
        $news = $this->newsRepository->find($news);

        dispatch(new UpdateViewJob($news));

        return new NewsResource($news);
    }
}
