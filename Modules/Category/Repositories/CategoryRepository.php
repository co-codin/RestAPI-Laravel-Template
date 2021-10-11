<?php


namespace Modules\Category\Repositories;


use App\Repositories\BaseRepository;
use Modules\Category\Models\Category;
use Modules\Category\Repositories\Criteria\CategoryRequestCriteria;
use Modules\Search\Contracts\IndexableRepository;
use Modules\Search\Repositories\IndexableRepositoryTrait;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryRepository extends BaseRepository implements IndexableRepository
{
    use IndexableRepositoryTrait;

    public function model()
    {
        return Category::class;
    }

    public function boot()
    {
        $this->pushCriteria(CategoryRequestCriteria::class);
    }

    public function getItemsToIndex()
    {
        return $this->scopeQuery(function (QueryBuilder $builder) {
            return $builder
                ->select([
                    'id',
                    'name',
                    'slug',
                    'status',
                    'parent_id'
                ]);
        });
    }
}
