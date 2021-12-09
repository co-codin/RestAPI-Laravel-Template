<?php


namespace Modules\Achievement\Dto;

use App\Dto\BaseDto;
use Illuminate\Http\UploadedFile;

class AchievementDto extends BaseDto
{
    public ?string $name;
    
    public ?UploadedFile $image;

    public mixed $is_enabled = 1;
}
