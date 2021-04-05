<?php


namespace Modules\Page\Dto;


use App\Dto\Dto;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PageDto
 * @package Modules\Page\Dto\Admin
 */
class PageDto extends Dto
{
    public ?int $parent_id;

    public ?string $name;

    public ?string $slug;

    public ?string $full_description;

    public ?int $status;
}
