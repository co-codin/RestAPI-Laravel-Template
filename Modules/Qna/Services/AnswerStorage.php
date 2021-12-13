<?php


namespace Modules\Qna\Services;


use Modules\Qna\Models\Answer;
use Modules\Qna\Dto\AnswerDto;
use Modules\Qna\Enums\AnswerStatus;
use Modules\Qna\Mail\ApprovedAnswerClientNotify;
use Modules\Qna\Mail\NewAnswerNotify;

class AnswerStorage
{
    /**
     * @throws \Exception
     */
    public function store(AnswerDto $answerDto): Answer
    {
        $answer = new Answer($answerDto->toArray());

        if (!$answer->save()) {
            throw new \Exception('Can not create Answer');
        }

        return $answer;
    }

    /**
     * @throws \Exception
     */
    public function update(Answer $answer, AnswerDto $answerDto): Answer
    {
        if (!$answer->update($answerDto->toArray())) {
            throw new \Exception('Can not update Answer');
        }

        return $answer;
    }

    /**
     * @throws \Exception
     */
    public function delete(Answer $answer): void
    {
        if (!$answer->delete()) {
            throw new \Exception('Can not delete Answer');
        }
    }

    /**
     * @throws \Exception
     */
    public function changeStatus(Answer $answer, AnswerStatus $status): void
    {
        if (!$answer->update(['status' => $status->value])) {
            throw new \Exception('Can not approve/reject Answer');
        }
    }
}
