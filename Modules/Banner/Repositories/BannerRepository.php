<?php

namespace Modules\Banner\Repositories;

use App\Repositories\BaseRepository;
use Modules\Banner\Models\Banner;
use Modules\Banner\Repositories\Criteria\BannerRequestCriteria;

class BannerRepository extends BaseRepository
{
    public function model()
    {
        return Banner::class;
    }

    public function boot()
    {
        $this->pushCriteria(BannerRequestCriteria::class);
    }

    public function getBannersByPage(string $page)
    {
        return $this->resetCriteria()
            ->scopeQuery(function($query) use ($page) {
                return $query->where('page', $page)
                    ->where('is_enabled', true)
                    ->orderBy('position');
            })
            ->get(['url', 'images']);
    }
}
