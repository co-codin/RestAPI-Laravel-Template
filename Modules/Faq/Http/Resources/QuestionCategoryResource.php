<?php

namespace Modules\Faq\Http\Resources;

use App\Enums\Status;
use App\Transformers\BaseJsonResource;

class QuestionCategoryResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', [
                'value' => $this->status,
                'description' => Status::getDescription($this->status),
            ]),
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
        ]);
    }
}
