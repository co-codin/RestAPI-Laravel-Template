<?php

namespace Modules\Product\Dto;

use App\Dto\BaseDtoCollection;

class VariationLinkDtoCollection extends BaseDtoCollection
{
    public function getSingleDtoClass(): string
    {
        return VariationLinkDto::class;
    }

    public function offsetGet($key): VariationLinkDto
    {
        return parent::offsetGet($key);
    }
}
