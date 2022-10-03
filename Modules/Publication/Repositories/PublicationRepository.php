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

    public function getHomePublications()
    {
        return $this->resetCriteria()
            ->scopeQuery(function($query) {
                return $query->where('is_enabled', true)
                    ->orderByDesc('published_at')
                    ->take(4);
            })
            ->get(['name', 'source', 'url', 'logo', 'published_at']);
    }
}
