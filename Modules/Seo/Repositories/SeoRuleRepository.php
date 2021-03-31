<?php


namespace Modules\Seo\Repositories;

use App\Repositories\BaseRepository;
use Modules\Seo\Models\SeoRule;

class SeoRuleRepository extends BaseRepository
{
    public function model()
    {
        return SeoRule::class;
    }
}
