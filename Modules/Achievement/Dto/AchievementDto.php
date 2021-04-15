<?php


namespace Modules\Achievement\Dto;

use App\Dto\Dto;
use Illuminate\Http\UploadedFile;

class AchievementDto extends Dto
{
    public ?string $name;

    public ?UploadedFile $image;

    /** @var mixed */
    public $is_enabled = 1;
}
