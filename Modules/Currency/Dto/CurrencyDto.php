<?php

namespace Modules\Currency\Dto;

use App\Dto\Dto;

class CurrencyDto extends Dto
{
    public ?string $name;

    public ?string $iso_code;

    public $rate;

    public $is_main;
}
