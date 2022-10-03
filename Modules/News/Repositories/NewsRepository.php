<?php


namespace Modules\News\Repositories;


use App\Enums\Status;
use App\Repositories\BaseRepository;
use Modules\News\Models\News;
use Modules\News\Repositories\Criteria\NewsRequestCriteria;

class NewsRepository extends BaseRepository
{
    public function model()
    {
        return News::class;
    }

    public function boot()
    {
        $this->pushCriteria(NewsRequestCriteria::class);
    }

    public function getHomeNews()
    {
        return $this->resetCriteria()
            ->scopeQuery(function ($query) {
                return $query
                    ->where('is_in_home', true)
                    ->where('status', Status::ACTIVE)
                    ->orderByDesc('published_at')
                    ->take(4);
            })
            ->get(['name', 'short_description', 'slug', 'image', 'published_at', 'view_num']);
    }
}
