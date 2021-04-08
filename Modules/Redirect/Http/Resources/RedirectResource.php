<?php


namespace Modules\Redirect\Http\Resources;


use App\Transformers\BaseJsonResource;

class RedirectResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
