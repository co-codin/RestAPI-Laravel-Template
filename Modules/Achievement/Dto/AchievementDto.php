<?php


namespace Modules\Achievement\Dto;

use App\Dto\Dto;

class AchievementDto extends Dto
{
    public ?string $name;

    public ?string $image;

    public $is_enabled;
}
