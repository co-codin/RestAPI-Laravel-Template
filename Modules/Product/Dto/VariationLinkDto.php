<?php

namespace Modules\Product\Dto;

use App\Dto\BaseDto;

class VariationLinkDto extends BaseDto
{
    public ?int $product_variation_id;

    public ?int $supplier;

    public ?string $resource;

    public ?bool $is_default;

    public ?array $check;

    public ?int $currency_id;

    public ?int $price;

    public ?int $availability;

    public ?string $info_updated_at;
}
