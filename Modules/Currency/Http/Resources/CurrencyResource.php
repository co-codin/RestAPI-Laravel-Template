<?php


namespace Modules\Currency\Http\Resources;

use App\Transformers\BaseJsonResource;

class CurrencyResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
