<?php


namespace Modules\Product\Services\Qna;


use Modules\Product\Dto\ProductQuestionDto;
use Modules\Product\Enums\ProductQuestionStatus;
use Modules\Product\Mail\ApprovedProductQuestionClientNotify;
use Modules\Product\Mail\NewQuestionNotify;
use Modules\Product\Models\ProductQuestion;
use function config;

class ProductQuestionStorage
{
    /**
     * @throws \Exception
     */
    public function store(ProductQuestionDto $questionDto): ProductQuestion
    {
        $question = new ProductQuestion($questionDto->toArray());

        if (!$question->save()) {
            throw new \Exception('Can not create Question');
        }

        $this->notifyNewQuestion($question);

        return $question;
    }

    /**
     * @throws \Exception
     */
    public function update(ProductQuestion $question, ProductQuestionDto $questionDto): ProductQuestion
    {
        if (!$question->update($questionDto->toArray())) {
            throw new \Exception('Can not update Question');
        }

        return $question;
    }

    /**
     * @throws \Exception
     */
    public function delete(ProductQuestion $question): void
    {
        if (!$question->delete()) {
            throw new \Exception('Can not delete Question');
        }
    }

    /**
     * @throws \Exception
     */
    public function changeStatus(ProductQuestion $question, ProductQuestionStatus $status): void
    {
        $question->status = $status->value;

        if (!$question->save()) {
            throw new \Exception('Can not approve/reject Question');
        }
    }

    public function notifyApproveOrReject(ProductQuestion $question, string $comment): void
    {
        $email = $question?->client?->email;

        if (!is_null($email)) {
            \Mail::to($email)
                ->queue(new ApprovedProductQuestionClientNotify($question, $comment));
        }
    }

    private function notifyNewQuestion(ProductQuestion $question): void
    {
        if (!is_null($question?->client)) {
            \Mail::to(config('product.new-question-notify-email'))
                ->queue(new NewQuestionNotify($question));
        }
    }
}
