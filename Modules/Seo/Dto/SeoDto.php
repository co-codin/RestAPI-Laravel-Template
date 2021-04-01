<?php


namespace Modules\Seo\Dto;


use App\Dto\Dto;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Seo\Enums\SeoType;

/**
 * Class SeoDto
 * @package Modules\Seo\Dto\Admin
 */
class SeoDto extends Dto
{
    public bool $is_enabled;

    public string $title;

    public string $h1;

    public string $description;

    public int $type = SeoType::Self;

    public ?array $meta_tags;
}
