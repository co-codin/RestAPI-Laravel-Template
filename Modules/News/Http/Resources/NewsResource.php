<?php


namespace Modules\News\Http\Resources;


use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;
use Modules\News\Models\News;
use Modules\Seo\Http\Resources\SeoResource;

/**
 * Class NewsResource
 * @package Modules\News\Http\Resources
 * @mixin News
 */
class NewsResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', Status::fromValue($this->status)->toArray()),
            'seo' => new SeoResource($this->whenLoaded('seo')),
        ]);
    }
}
