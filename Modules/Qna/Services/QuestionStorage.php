<?php


namespace Modules\Qna\Services;


use Modules\Qna\Dto\QuestionDto;
use Modules\Qna\Enums\QuestionStatus;
use Modules\Qna\Mail\ApprovedQuestionClientNotify;
use Modules\Qna\Mail\NewQuestionNotify;
use Modules\Qna\Models\Question;

class QuestionStorage
{
    /**
     * @throws \Exception
     */
    public function store(QuestionDto $questionDto): Question
    {
        $question = new Question($questionDto->toArray());

        if (!$question->save()) {
            throw new \Exception('Can not create Question');
        }

        $this->notifyNewQuestion($question);

        return $question;
    }

    /**
     * @throws \Exception
     */
    public function update(Question $question, QuestionDto $questionDto): Question
    {
        if (!$question->update($questionDto->toArray())) {
            throw new \Exception('Can not update Question');
        }

        return $question;
    }

    /**
     * @throws \Exception
     */
    public function delete(Question $question): void
    {
        if (!$question->delete()) {
            throw new \Exception('Can not delete Question');
        }
    }

    /**
     * @throws \Exception
     */
    public function changeStatus(Question $question, QuestionStatus $status): void
    {
        if (!$question->update(['status' => $status->value])) {
            throw new \Exception('Can not approve/reject Question');
        }
    }

    public function notifyApproveOrReject(Question $question, string $comment): void
    {
        $email = $question->client->email;

        if (!is_null($email)) {
            \Mail::to($email)->queue(new ApprovedQuestionClientNotify($question, $comment));
        }
    }

    public function notifyNewQuestion(Question $question): void
    {
        \Mail::to(config('qna.new-answer-notify-email'))
            ->queue(new NewQuestionNotify($question));
    }
}
