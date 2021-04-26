<?php

namespace Modules\Faq\Http\Resources;

use App\Enums\Status;
use App\Transformers\BaseJsonResource;
use Modules\Faq\Models\Question;

/**
 * Class QuestionResource
 * @package Modules\Faq\Http\Resources
 * @mixin Question
 */
class QuestionResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', Status::toJson($this->status)),
            'question_category' => new QuestionCategoryResource($this->whenLoaded('questionCategory')),
        ]);
    }
}
