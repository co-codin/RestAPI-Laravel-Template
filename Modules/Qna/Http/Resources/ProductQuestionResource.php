<?php

namespace Modules\Qna\Http\Resources;

use App\Http\Resources\BaseJsonResource;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Qna\Enums\ProductQuestionStatus;
use Modules\Qna\Models\ProductQuestion;

/**
 * @mixin ProductQuestion
 */
class ProductQuestionResource extends BaseJsonResource
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
                'description' => ProductQuestionStatus::getDescription($this->status),
            ]),
            'client' => new ClientResource($this->whenLoaded('client')),
            'answers' => ProductAnswerResource::collection($this->whenLoaded('answers')),
            'products' => ProductResource::collection($this->whenLoaded('products'))
        ]);
    }
}
