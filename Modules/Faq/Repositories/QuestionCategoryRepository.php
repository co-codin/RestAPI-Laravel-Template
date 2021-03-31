<?php

namespace Modules\Faq\Repositories;

use App\Repositories\BaseRepository;
use Modules\Faq\Models\QuestionCategory;

class QuestionCategoryRepository extends BaseRepository
{
    public function model()
    {
        return QuestionCategory::class;
    }
}
