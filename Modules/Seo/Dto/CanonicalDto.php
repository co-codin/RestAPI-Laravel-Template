<?php


namespace Modules\Seo\Dto;


use App\Dto\BaseDto;

/**
 * Class CanonicalDto
 * @package Modules\Seo\Dto
 */
class CanonicalDto extends BaseDto
{
    public ?string $url;
    public ?string $canonical;
}
