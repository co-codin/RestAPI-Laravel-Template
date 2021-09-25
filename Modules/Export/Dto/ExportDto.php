<?php

namespace Modules\Export\Dto;

use App\Dto\BaseDto;

class ExportDto extends BaseDto
{
    public ?string $name;

    public ?int $type;

    public ?string $filename;

    public ?int $frequency;

    public ?array $parameters;

    public ?int $assigned_by_id;
}
