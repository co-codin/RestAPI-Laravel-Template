<?php

namespace Modules\Faq\Services;

use Modules\Faq\Dto\QuestionDto;
use Modules\Faq\Models\Question;

class QuestionStorage
{
    public function store(QuestionDto $questionDto)
    {
        $question = new Question($questionDto->toArray());

        if (!$question->save()) {
            throw new \LogicException('can not create question.');
        }

        return $question;
    }

    public function update(Question $question, QuestionDto $questionDto)
    {
        if (!$question->update($questionDto->toArray())) {
            throw new \LogicException('can not update question.');
        }

        return $question;
    }

    public function delete(Question $question)
    {
        if (!$question->delete()) {
            throw new \LogicException('can not delete question.');
        }
    }
}
