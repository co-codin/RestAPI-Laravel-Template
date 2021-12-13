<?php

namespace Modules\Qna\Http\Resources;

use App\Http\Resources\BaseJsonResource;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;
use Modules\Qna\Enums\QuestionStatus;
use Modules\Qna\Models\Question;

/**
 * @mixin Question
 */
class QuestionResource extends BaseJsonResource
{
    /**
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', [
                'value' => $this->status,
                'description' => QuestionStatus::getDescription($this->status),
            ]),
            'client' => new ClientResource($this->whenLoaded('client')),
            'answers' => AnswerResource::collection($this->whenLoaded('answers'))
        ]);
    }
}
