<?php


namespace Modules\Seo\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Modules\Seo\Models\CanonicalEntity;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CanonicalRepositoryInterface
 * @package Modules\Seo\Repositories
 */
interface CanonicalRepositoryInterface extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * @inheritDoc
     */
    public function model();

    /**
     * @param string $url
     * @param string|null $cacheKey
     * @return CanonicalEntity|null
     */
    public function findByUrl(string $url, ?string $cacheKey = null): ?CanonicalEntity;

    /**
     * @param array $urls
     * @param string|null $cacheKey
     * @return Collection|CanonicalEntity[]
     */
    public function getByUrls(array $urls, ?string $cacheKey = null): Collection;
}
