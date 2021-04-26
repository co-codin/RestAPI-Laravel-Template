<?php


namespace Modules\Page\Http\Resources;


use App\Enums\Status;
use App\Transformers\BaseJsonResource;
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
            'status' => $this->whenRequested('status', Status::toJson($this->status)),
            'seo' => new SeoResource($this->whenLoaded('seo')),
        ]);
    }
}
