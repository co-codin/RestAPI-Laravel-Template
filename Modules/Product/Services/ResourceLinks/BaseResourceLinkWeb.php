<?php

namespace Modules\Product\Services\ResourceLinks;


use Modules\Product\Models\VariationLink;

abstract class BaseResourceLinkWeb extends BaseResourceLink
{
    public function __construct(
        protected VariationLink $variationLink
    ) {}
}
