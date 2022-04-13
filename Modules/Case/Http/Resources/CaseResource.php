<?php

namespace Modules\Case\Http\Resources;

use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;

class CaseResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', fn() => Status::fromValue($this->status)->toArray()),
        ]);
    }
}
