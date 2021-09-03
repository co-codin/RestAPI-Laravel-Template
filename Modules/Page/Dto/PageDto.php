<?php


namespace Modules\Page\Dto;


use App\Dto\BaseDto;

/**
 * Class PageDto
 * @package Modules\Page\Dto\Admin
 */
class PageDto extends BaseDto
{
    public ?int $parent_id;

    public ?string $name;

    public ?string $slug;

    public ?string $full_description;

    /** @var mixed */
    public $status;

    public ?int $assigned_by_id;
}
