<?php


namespace Modules\Search\Services;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Search\Contracts\IndexableRepository;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * @property RepositoryInterface|IndexableRepository $repository
 */
abstract class SearchService
{
    abstract protected function getQuery(string $term): array;

    /**
     * @return IndexableRepository|RepositoryInterface
     * @throws \Exception
     */
    private function getRepository(): IndexableRepository
    {
        $class = static::class;

        if (!property_exists($class, 'repository') || is_null($this->repository)) {
            throw new \Exception("Class $class must have the repository property");
        }

        if (!$this->repository instanceof IndexableRepository) {
            throw new \Exception("Class $class must have the repository implement IndexableRepository interface");
        }

        return $this->repository;
    }

    /**
     * @return Model[]|Collection|null
     * @throws \Exception
     */
    public function getEntities(string $term, int $size = 1): Collection
    {
        $query = $this->getQuery($term);

        return $this->getRepository()->findForSearch($query, $size);
    }
}
