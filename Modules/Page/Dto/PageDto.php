<?php


namespace Modules\Page\Dto;


use App\Dto\BaseDto;
use App\Http\Requests\BaseFormRequest;

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
}
