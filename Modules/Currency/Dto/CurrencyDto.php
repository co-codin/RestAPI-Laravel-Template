<?php

namespace Modules\Currency\Dto;

use App\Dto\Dto;

class CurrencyDto extends Dto
{
    public ?string $name;

    public ?string $code;

    public ?float $rate;

    public $is_main;
}
