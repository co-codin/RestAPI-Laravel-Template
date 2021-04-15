<?php


namespace Modules\News\Repositories;


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
}
