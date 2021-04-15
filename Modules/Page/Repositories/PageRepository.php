<?php


namespace Modules\Page\Repositories;


use App\Repositories\BaseRepository;
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
        $this->pushCriteria(PageRequestCriteria::class);
    }
}
