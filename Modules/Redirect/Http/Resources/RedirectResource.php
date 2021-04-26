<?php


namespace Modules\Redirect\Http\Resources;


use App\Transformers\BaseJsonResource;
use Modules\Redirect\Models\Redirect;

/**
 * Class RedirectResource
 * @package Modules\Redirect\Http\Resources
 * @mixin Redirect
 */
class RedirectResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
