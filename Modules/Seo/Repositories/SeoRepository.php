<?php


namespace Modules\Seo\Repositories;

use App\Repositories\BaseRepository;
use Modules\Seo\Models\Seo;

class SeoRepository extends BaseRepository
{
    public function model()
    {
        return Seo::class;
    }
}
