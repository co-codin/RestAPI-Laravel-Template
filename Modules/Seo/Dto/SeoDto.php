<?php


namespace Modules\Seo\Dto;


use App\Dto\Dto;

/**
 * Class SeoDto
 * @package Modules\Seo\Dto\Admin
 */
class SeoDto extends Dto
{
    public $is_enabled = 1;

    public string $title;

    public string $h1;

    public string $description;

    public ?array $meta_tags;
}
