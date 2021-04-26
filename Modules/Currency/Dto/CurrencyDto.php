<?php

namespace Modules\Currency\Dto;

use App\Dto\BaseDto;

class CurrencyDto extends BaseDto
{
    public ?string $name;

    public ?string $iso_code;

    public $rate;

    public $is_main;
}
