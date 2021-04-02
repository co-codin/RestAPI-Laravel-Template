<?php


namespace Modules\Publication\Repositories;


use App\Repositories\BaseRepository;
use Modules\Publication\Models\Publication;

class PublicationRepository extends BaseRepository
{
    public function model()
    {
        return Publication::class;
    }

    public function boot()
    {

    }
}
