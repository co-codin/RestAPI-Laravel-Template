<?php

namespace Modules\Product\Dto;

use App\Dto\BaseDto;

class ProductAnalogDto extends BaseDto
{
    public int $product_id;

    public int $analog_id;

    public int $position;
}
