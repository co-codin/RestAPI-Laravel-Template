<?php


namespace Modules\Redirect\Repositories;


use App\Repositories\BaseRepository;
use Modules\Redirect\Models\Redirect;

class RedirectRepository extends BaseRepository
{
    public function model()
    {
        return Redirect::class;
    }

    public function boot()
    {
        $this->pushCriteria();
    }
}
