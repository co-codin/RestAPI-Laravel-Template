<?php


namespace Modules\Publication\Dto;


use App\Dto\Dto;

class PublicationDto extends Dto
{
    public ?string $name;

    public ?string $url;

    public ?string $source;

    public ?bool $is_enabled;

    public ?string $published_at;

}
