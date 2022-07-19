<?php

namespace Modules\News\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\News\Http\Resources\NewsResource;
use Modules\News\Models\News;
use Modules\News\Repositories\NewsRepository;

class NewsController extends Controller
{
    public function __construct(
        protected NewsRepository $newsRepository
    ) {
        $this->authorizeResource(News::class, 'news');
    }

    public function index()
    {
        $news = $this->newsRepository->jsonPaginate();

        return NewsResource::collection($news);
    }

    public function show(News $news)
    {
        return new NewsResource($news);
    }
}
