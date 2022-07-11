<?php

namespace Modules\News\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\News\Http\Resources\NewsPageResource;
use Modules\News\Repositories\NewsRepository;

class NewsPageController extends Controller
{
    public function __construct(
        protected NewsRepository $newsRepository
    ) {
        $this->newsRepository->resetCriteria();
    }

    public function index()
    {
        $perPage = request()->get('per_page');
        $page = request()->get('page');

        $news = $this->newsRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->active()
                    ->where('is_in_home', '=', true)
                    ->addSelect('id', 'name', 'short_description', 'slug', 'image', 'published_at', 'view_num', 'is_in_home')
                    ;
            })
            ->orderBy('published_at', 'desc')
            ->paginate($perPage, $page)
        ;

        return NewsPageResource::collection($news);
    }

    public function show(string $news)
    {
        $brand = $this->newsRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect(
                        'id', 'name', 'slug', 'view_num', 'published_at', 'short_description',
                        'full_description', 'sources',
                    )
                    ->with(['seo' => function ($query) {
                        $query->addSelect('seoable_id', 'is_enabled', 'title', 'h1', 'description');
                    }])
                    ;
            })
            ->findByField('slug', $news)
            ->first();

        return new NewsPageResource($brand);
    }
}
