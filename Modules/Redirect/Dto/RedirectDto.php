<?php


namespace Modules\Redirect\Dto;


use App\Dto\Dto;

/**
 * Class RedirectDto
 * @package Modules\Redirect\Dto\Admin
 */
class RedirectDto extends Dto
{
    public ?string $source;

    public ?string $destination;

    public int $code = 301;
}
