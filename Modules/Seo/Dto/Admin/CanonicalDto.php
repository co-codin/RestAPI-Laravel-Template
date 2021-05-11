<?php


namespace Modules\Seo\Dto\Admin;


use App\Dto\BaseDto;

/**
 * Class CanonicalDto
 * @package Modules\Seo\Dto\Admin
 */
class CanonicalDto extends BaseDto
{
    public string $url;
    public ?string $canonical;
}
