<?php


namespace Modules\Publication\Dto;


use App\Dto\BaseDto;
use Illuminate\Http\UploadedFile;

class PublicationDto extends BaseDto
{
    public ?string $name;

    public ?string $url;

    public ?string $source;

    public ?bool $is_enabled;

    public ?UploadedFile $logo;

    public ?string $published_at;
}
