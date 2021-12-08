<?php

namespace Modules\Review\Http\Resources;

use App\Http\Resources\BaseJsonResource;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;
use Modules\Review\Enums\ProductReviewStatus;
use Modules\Review\Models\ProductReview;

/**
 * @mixin ProductReview
 */
class ProductReviewResource extends BaseJsonResource
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
                'description' => ProductReviewStatus::getDescription($this->status),
            ]),
            'is_confirmed' => [
                'value' => $this->is_confirmed,
                'description' => $this->is_confirmed ? 'Подтвержден' : 'Не подтвержден',
            ],
            'ratings_avg' => !is_null($this->ratings) ? round(array_sum($this->ratings) / count($this->ratings), 1) : null,
            'client' => new ClientResource($this->whenLoaded('client'))
        ]);
    }
}
