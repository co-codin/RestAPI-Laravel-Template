<?php


namespace Modules\Redirect\Dto;


use App\Dto\BaseDto;

/**
 * Class RedirectDto
 * @package Modules\Redirect\Dto\Admin
 */
class RedirectDto extends BaseDto
{
    public ?string $source;

    public ?string $destination;

    public int $code = 301;
}
