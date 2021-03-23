<?php


namespace Modules\Achievement\Dto;

use App\Dto\Dto;

class AchievementDto extends Dto
{
    public string|null $name;

    public string|null $image;

    public bool|null $is_enabled;
}
