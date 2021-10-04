<?php


namespace App\Http\Resources;

use App\Models\FieldValue;

/**
 * Class FieldValueResource
 * @package App\Http\Resources
 * @mixin FieldValue
 */
class FieldValueResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
