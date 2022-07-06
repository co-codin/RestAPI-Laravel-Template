<?php

namespace Modules\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Repositories\Criteria\CategoryPageCriteria;

class CategoryPageController extends Controller
{
    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {
        $this->categoryRepository
            ->resetCriteria()
            ->pushCriteria(CategoryPageCriteria::class);
    }

    public function index()
    {

    }

    public function show(int $category)
    {

    }
}
