<?php


namespace Modules\Achievement\Dto;

use App\Dto\BaseDto;

class AchievementDto extends BaseDto
{
    public ?string $name;

    public ?string $image;

    public mixed $is_enabled = 1;

}
