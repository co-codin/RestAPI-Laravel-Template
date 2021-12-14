<?php

namespace Modules\Qna\Http\Resources;

use App\Http\Resources\BaseJsonResource;
use Illuminate\Http\Request;
use Modules\Qna\Models\ProductQuestion;

/**
 * @mixin ProductQuestion
 */
class ProductAnswerResource extends BaseJsonResource
{
    /**
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'question' => new ProductQuestionResource($this->whenLoaded('question')),
        ]);
    }
}
