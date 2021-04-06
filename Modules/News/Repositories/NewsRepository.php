<?php


namespace Modules\News\Repositories;


use App\Repositories\BaseRepository;
use App\Repositories\Criteria\ActiveStatusCriteria;
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
        $this->pushCriteria(ActiveStatusCriteria::class);
        $this->pushCriteria(NewsRequestCriteria::class);
    }
}
