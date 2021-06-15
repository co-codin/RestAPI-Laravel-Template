<?php


namespace Modules\Export\Repositories;


use App\Repositories\BaseRepository;
use Modules\Achievement\Repositories\Criteria\ExportRequestCriteria;
use Modules\Export\Models\Export;

class ExportRepository extends BaseRepository
{
    public function model()
    {
        return Export::class;
    }

    public function boot()
    {
        $this->pushCriteria(ExportRequestCriteria::class);
    }
}
