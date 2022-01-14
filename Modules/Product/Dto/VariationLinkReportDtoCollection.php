<?php

namespace Modules\Product\Dto;

use App\Dto\BaseDtoCollection;

class VariationLinkReportDtoCollection extends BaseDtoCollection
{
    public function getSingleDtoClass(): string
    {
        return VariationLinkReportDto::class;
    }

    public function offsetGet($key): VariationLinkReportDto
    {
        return parent::offsetGet($key);
    }
}
