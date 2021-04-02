<?php

namespace Modules\Faq\Services;

use Modules\Faq\Dto\QuestionDto;
use Modules\Faq\Dto\QuestionSortDto;
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

    public function sort(array $questions)
    {
        foreach ($questions as $question) {
            Question::query()
                ->where('id', $question['id'])
                ->update(['position' => $question['position']]);
        }
    }
}
