<?php


namespace Modules\Currency\Http\Resources;

use App\Http\Resources\BaseJsonResource;
use Modules\Currency\Models\Currency;

/**
 * Class CurrencyResource
 * @package Modules\Currency\Http\Resources
 * @mixin Currency
 */
class CurrencyResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
