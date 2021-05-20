<?php


namespace Modules\Attribute\Dto;


use App\Dto\BaseDto;

class AttributeDto extends BaseDto
{
    public string $name;

    public $is_default;
}
