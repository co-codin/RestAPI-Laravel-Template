<?php

namespace Modules\Customer\Http\Resources;

use App\Http\Resources\BaseJsonResource;
use Modules\Customer\Enums\CustomerType;
use Modules\Customer\Models\CustomerReview;
use Illuminate\Http\Request;

/**
 * Class CustomerReviewResource
 * @package Modules\Customer\Http\Resources
 * @mixin CustomerReview
 */
class CustomerReviewResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'type' => $this->whenRequested('type', [
                'value' => $this->type,
                'description' => CustomerType::getDescription($this->type),
            ]),
            'is_home' => $this->whenRequested('is_home', [
                'value' => $this->is_home,
                'description' => $this->is_home ? 'На главной странице': 'Не на главной странице',
            ]),
        ]);
    }
}
