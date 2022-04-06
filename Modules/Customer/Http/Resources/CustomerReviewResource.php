<?php

namespace Modules\Customer\Http\Resources;

use App\Http\Resources\BaseJsonResource;
use Modules\Customer\Enums\CustomerType;
use Modules\Customer\Models\CustomerReview;
use Illuminate\Http\Request;

class CustomerReviewResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'type' => $this->whenRequested('type', [
                'value' => $this->type,
                'description' => CustomerType::getDescription($this->type),
            ]),
        ]);
    }
}
