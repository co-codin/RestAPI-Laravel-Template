<?php

namespace Modules\Brand\Dto;

use App\Dto\Dto;

class BrandDto extends Dto
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $image;

    /**
     * @var string
     */
    public $website;

    /**
     * @var string
     */
    public $full_description;

    /**
     * @var int
     */
    public $status;

    /**
     * @var int
     */
    public $in_home;

    /**
     * @var int
     */
    public $position;

    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $short_description;
}
