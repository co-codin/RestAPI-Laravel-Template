<?php


namespace Modules\Seo\Dto;


use App\Dto\BaseDto;

/**
 * Class SeoRuleDto
 * @package Modules\Seo\Dto\Admin
 */
class SeoRuleDto extends BaseDto
{
    public ?string $name;

    public ?string $url;
}
