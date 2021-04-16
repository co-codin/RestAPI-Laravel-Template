<?php


namespace Modules\Category\Dto;

use App\Dto\Dto;
use Illuminate\Http\UploadedFile;

class CategoryDto extends Dto
{
    public $parent_id;

    public ?string $name;

    public ?string $slug;

    public ?string $product_name;

    public ?string $full_description;

    public $status;

    public $is_hidden_in_parents = false;

    public $is_in_home = false;

    public ?UploadedFile $image;
}
