<?php


namespace Modules\Publication\Dto;


use App\Dto\BaseDto;

class PublicationDto extends BaseDto
{
    public ?string $name;

    public ?string $url;

    public ?string $source;

    public ?bool $is_enabled;

    public ?string $published_at;
}
