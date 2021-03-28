<?php


namespace Modules\Category\Dto;

use App\Dto\Dto;

class CategoryDto extends Dto
{
    public string $parent_id;

    public string $name;

    public string $slug;

    public string $product_name;

    public string $full_description;

    public string $status;

    public string $is_hidden_in_parents;

    public string $is_in_home;

    public string $image;

    public string $short_properties;

}
