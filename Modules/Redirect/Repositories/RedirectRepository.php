<?php


namespace Modules\Redirect\Repositories;


use App\Repositories\BaseRepository;
use Modules\Redirect\Models\Redirect;
use Modules\Redirect\Repositories\Criteria\RedirectRequestCriteria;

class RedirectRepository extends BaseRepository
{
    public function model()
    {
        return Redirect::class;
    }

    public function boot()
    {
        $this->pushCriteria(RedirectRequestCriteria::class);
    }

    public function findByOldUrl(string $oldUrl)
    {
        return $this
            ->scopeQuery(fn($q) => $q->where('old_url', $oldUrl))
            ->first();
    }
}
