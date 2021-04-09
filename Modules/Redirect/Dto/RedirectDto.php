<?php


namespace Modules\Redirect\Dto;


use App\Dto\Dto;

/**
 * Class RedirectDto
 * @package Modules\Redirect\Dto\Admin
 */
class RedirectDto extends Dto
{
    public ?string $old_url;

    public ?string $new_url;

    public int $code = 301;
}
