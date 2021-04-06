<?php


namespace Modules\News\Dto;


use App\Dto\Dto;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class NewsDto
 * @package Modules\News\Dto\Admin
 */
class NewsDto extends Dto
{
    public ?string $name;

    public ?string $short_description;

    public ?string $full_description;

    public ?int $status;

    public ?string $slug;

    public ?string $image;

    public $is_in_home = false;

    public ?string $published_at;
}
