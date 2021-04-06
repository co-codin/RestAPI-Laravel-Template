<?php


namespace Modules\News\Http\Resources;


use App\Enums\Status;
use App\Transformers\BaseJsonResource;
use Modules\Seo\Http\Resources\SeoResource;

class NewsResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', [
                'value' => $this->status,
                'description' => Status::getDescription($this->status),
            ]),
            'seo' => new SeoResource($this->whenLoaded('seo')),
        ]);
    }
}
