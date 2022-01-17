<?php

namespace Modules\Product\Dto;

use App\Dto\BaseDto;
use Modules\Product\Enums\SupplierEnum;
use Modules\Product\Enums\VariationLinkReportType;

class VariationLinkReportDto extends BaseDto
{
    public int $id;

    public VariationLinkReportType $type;

    public string $message;

    public string $comment = '';

    public ?int $productId;

    public ?SupplierEnum $supplier;

    public ?string $variationName;
}
