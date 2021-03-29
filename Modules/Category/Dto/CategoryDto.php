<?php


namespace Modules\Category\Dto;

use App\Dto\Dto;

class CategoryDto extends Dto
{
    public ?int $parent_id;

    public ?string $name;

    public ?string $slug;

    public ?string $product_name;

    public ?string $full_description;

    public ?int $status;

    public ?bool $is_hidden_in_parents;

    public ?bool $is_in_home;

    public ?string $image;

    public ?array $short_properties;

}
