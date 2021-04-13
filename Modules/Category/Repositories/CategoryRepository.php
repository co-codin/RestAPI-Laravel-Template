<?php


namespace Modules\Category\Repositories;


use App\Repositories\BaseRepository;
use App\Repositories\Criteria\ActiveStatusCriteria;
use Modules\Category\Models\Category;
use Modules\Category\Repositories\Criteria\CategoryRequestCriteria;

class CategoryRepository extends BaseRepository
{
    public function model()
    {
        return Category::class;
    }

    public function boot()
    {
        $this->pushCriteria(CategoryRequestCriteria::class);
    }
}
