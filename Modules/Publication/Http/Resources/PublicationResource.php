<?php


namespace Modules\Publication\Http\Resources;


use App\Http\Resources\BaseJsonResource;

class PublicationResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
