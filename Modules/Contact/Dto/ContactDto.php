<?php

namespace Modules\Contact\Dto;

use App\Dto\BaseDto;
use Illuminate\Http\UploadedFile;

class ContactDto extends BaseDto
{
    public ?string $first_name;

    public ?string $last_name;

    public ?string $email;

    public ?string $phone;

    public ?string $job_position;

    public UploadedFile|string|null $image;

    public ?int $position;

    public mixed $is_enabled = 1;
}
