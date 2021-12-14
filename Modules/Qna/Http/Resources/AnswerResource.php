<?php

namespace Modules\Qna\Http\Resources;

use App\Http\Resources\BaseJsonResource;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;
use Modules\Qna\Models\Question;

/**
 * @mixin Question
 */
class AnswerResource extends BaseJsonResource
{
    /**
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'question' => new QuestionResource($this->whenLoaded('question')),
            'client' => new ClientResource($this->whenLoaded('client'))
        ]);
    }
}
