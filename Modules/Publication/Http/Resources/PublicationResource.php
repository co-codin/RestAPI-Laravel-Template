<?php


namespace Modules\Publication\Http\Resources;


use App\Transformers\BaseJsonResource;
use Modules\Publication\Models\Publication;

/**
 * Class PublicationResource
 * @package Modules\Publication\Http\Resources
 * @mixin Publication
 */
class PublicationResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
