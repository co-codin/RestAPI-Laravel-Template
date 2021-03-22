<?php


namespace Modules\Achievement\Dto;

use App\Dto\Dto;

class AchievementDto extends Dto
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $image;

    /**
     * @var boolean
     */
    public $is_enabled;
}
