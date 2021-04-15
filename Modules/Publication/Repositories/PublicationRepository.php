<?php


namespace Modules\Publication\Repositories;


use App\Repositories\BaseRepository;
use App\Repositories\Criteria\IsEnabledCriteria;
use Modules\Publication\Models\Publication;
use Modules\Publication\Repositories\Criteria\PublicationRequestCriteria;

class PublicationRepository extends BaseRepository
{
    public function model()
    {
        return Publication::class;
    }

    public function boot()
    {
        $this->pushCriteria(PublicationRequestCriteria::class);
    }
}
