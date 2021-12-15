<?php


namespace Modules\News\Dto;


use App\Dto\BaseDto;
use Illuminate\Http\UploadedFile;

/**
 * Class NewsDto
 * @package Modules\News\Dto\Admin
 */
class NewsDto extends BaseDto
{
    public ?string $name;

    public ?string $short_description;

    public ?string $full_description;

    public $status;

    public ?string $slug;

    public ?string $category;

    public ?UploadedFile $image;

    public $is_image_changed;

    public $is_in_home = false;

    public ?string $published_at;

    public ?int $assigned_by_id;

    public ?int $view_num;
}
