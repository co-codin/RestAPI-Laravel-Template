<?php

namespace Modules\Geo\Dto;

use App\Dto\BaseDto;

class OrderPointDto extends BaseDto
{
    public ?string $name;

    public ?int $city_id;

    public ?string $address;

    public ?array $coordinate;

    public ?string $embed_map_url;

    public ?string $phone;

    public ?string $email;

    public ?string $info;

    public ?array $timetable;

    public ?int $type;

    public ?int $status;
}
