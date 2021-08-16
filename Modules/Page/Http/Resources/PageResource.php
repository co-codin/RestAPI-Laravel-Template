<?php


namespace Modules\Page\Http\Resources;


use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;
use Modules\Page\Models\Page;
use Modules\Seo\Http\Resources\SeoResource;

/**
 * Class PageResource
 * @package Modules\Page\Http\Resources
 * @mixin Page
 */
class PageResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', Status::fromValue($this->status)->toArray()),
            'seo' => new SeoResource($this->whenLoaded('seo')),
        ]);
    }
}
