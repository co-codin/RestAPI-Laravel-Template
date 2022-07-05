<?php

namespace Modules\Client\Dto;

use App\Dto\BaseDto;

class ClientPayerDto extends BaseDto
{
    public int $org_type;

    public string $name;

    public int|string $inn;

    public string $delivery_address;

    public ?string $site;

    public ?string $email;

    public ?string $position;
}
