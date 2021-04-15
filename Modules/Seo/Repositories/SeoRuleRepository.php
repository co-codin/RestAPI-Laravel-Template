<?php


namespace Modules\Seo\Repositories;

use App\Repositories\BaseRepository;
use Modules\Seo\Models\SeoRule;
use Modules\Seo\Repositories\Criteria\SeoRuleRequestCriteria;

class SeoRuleRepository extends BaseRepository
{
    public function model()
    {
        return SeoRule::class;
    }

    public function boot()
    {
        $this->pushCriteria(SeoRuleRequestCriteria::class);
    }
}
