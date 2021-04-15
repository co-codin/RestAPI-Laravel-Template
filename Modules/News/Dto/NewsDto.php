<?php


namespace Modules\News\Dto;


use App\Dto\Dto;
use Illuminate\Http\UploadedFile;

/**
 * Class NewsDto
 * @package Modules\News\Dto\Admin
 */
class NewsDto extends Dto
{
    public ?string $name;

    public ?string $short_description;

    public ?string $full_description;

    public $status;

    public ?string $slug;

    public ?UploadedFile $image;

    public $is_in_home = false;

    public ?string $published_at;
}
