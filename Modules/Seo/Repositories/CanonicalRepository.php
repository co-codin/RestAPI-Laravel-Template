<?php


namespace Modules\Seo\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection as SupportCollection;
use Modules\Seo\Models\CanonicalEntity;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

/**
 * Class CanonicalRepository
 * @package Modules\Seo\Repositories
 * @property CanonicalEntity $model
 */
class CanonicalRepository extends BaseRepository implements CanonicalRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CanonicalEntity::class;
    }

    /**
     * @param string $url
     * @param string|null $cacheKey
     * @return CanonicalEntity|null
     */
    public function findByUrl(string $url, ?string $cacheKey = null): ?CanonicalEntity
    {
        if (!is_null($cacheKey)) {
            return \Cache::store('array')->rememberForever("$cacheKey-canonical", function () use ($url) {
                return $this->get()->where('url', $url)->first();
            });
        }

        return $this->get()->where('url', $url)->first();
    }

    /**
     * @param array $urls
     * @param string|null $cacheKey
     * @return Collection|CanonicalEntity[]
     */
    public function getByUrls(array $urls, ?string $cacheKey = null): Collection
    {
        if (!is_null($cacheKey)) {
            return \Cache::store('array')->rememberForever($cacheKey, function () use ($urls) {
                return $this->get()->whereIn('url', $urls);
            });
        }

        return $this->get()->whereIn('url', $urls);
    }
}
