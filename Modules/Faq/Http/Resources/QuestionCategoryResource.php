<?php

namespace Modules\Faq\Http\Resources;

use App\Enums\Status;
use App\Transformers\BaseJsonResource;
use Modules\Faq\Models\QuestionCategory;

/**
 * Class QuestionCategoryResource
 * @package Modules\Faq\Http\Resources
 * @mixin QuestionCategory
 */
class QuestionCategoryResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', Status::toJson($this->status)),
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
        ]);
    }
}
