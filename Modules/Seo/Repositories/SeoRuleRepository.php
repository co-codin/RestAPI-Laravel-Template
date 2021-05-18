<?php


namespace Modules\Seo\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Modules\Seo\Models\SeoRule;
use Modules\Seo\Repositories\Criteria\SeoRuleEnabledCriteria;
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
        $this->pushCriteria(SeoRuleEnabledCriteria::class);
    }

    /**
     * @param string $url
     * @param string|null $cacheKey
     * @return SeoRule|null
     */
    public function findByUrl(string $url, ?string $cacheKey = null): ?SeoRule
    {
        if (!is_null($cacheKey)) {
            return \Cache::store('array')->rememberForever("$cacheKey-seo-rule", function () use ($url) {
                return $this->where('url', $url)->first();
            });
        }

        return $this->where('url', $url)->first();
    }

    /**
     * @param array $urls
     * @param string|null $cacheKey
     * @return Collection|SeoRule[]
     */
    public function getByUrls(array $urls, ?string $cacheKey = null): Collection
    {
        if (!is_null($cacheKey)) {
            return \Cache::store('array')->rememberForever($cacheKey, function () use ($urls) {
                return $this->whereIn('url', $urls)->get();
            });
        }

        return $this->whereIn('url', $urls)->get();
    }
}
