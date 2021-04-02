<?php

namespace Modules\Faq\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\Criteria\ActiveStatusCriteria;
use Modules\Faq\Models\QuestionCategory;
use Modules\Faq\Repositories\Criteria\QuestionCategoryRequestCriteria;

class QuestionCategoryRepository extends BaseRepository
{
    public function model()
    {
        return QuestionCategory::class;
    }

    public function boot()
    {
        $this->pushCriteria(ActiveStatusCriteria::class);
        $this->pushCriteria(QuestionCategoryRequestCriteria::class);
    }
}
