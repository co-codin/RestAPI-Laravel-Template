<?php

namespace Modules\Faq\Repositories;

use App\Repositories\BaseRepository;
use Modules\Faq\Models\Question;
use Modules\Faq\Repositories\Criteria\ActiveStatusCriteria;
use Modules\Faq\Repositories\Criteria\QuestionRequestCriteria;

class QuestionRepository extends BaseRepository
{
    public function model()
    {
        return Question::class;
    }

    public function boot()
    {
        $this->pushCriteria(ActiveStatusCriteria::class);
        $this->pushCriteria(QuestionRequestCriteria::class);
    }
}
