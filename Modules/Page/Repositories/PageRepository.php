<?php


namespace Modules\Page\Repositories;


use App\Repositories\BaseRepository;
use App\Traits\IsActive;
use Modules\Page\Models\Page;
use Modules\Page\Repositories\Criteria\PageRequestCriteria;

class PageRepository extends BaseRepository
{
    public function model()
    {
        return Page::class;
    }

    public function boot()
    {
        $this->pushCriteria(IsActive::class);
        $this->pushCriteria(PageRequestCriteria::class);
    }
}
