<?php

namespace Modules\Product\Services\ResourceLinks;

use Modules\Product\Enums\Availability;
use Modules\Product\Models\VariationLink;

abstract class BaseResourceLink
{
    abstract public function getCurrencyId(): int;

    abstract public function getPrice(): int;

    abstract public function getAvailability(): Availability;

    public function __construct(
        protected VariationLink $variationLink,
    ) {}
}
