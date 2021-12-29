<?php


namespace Modules\Product\Services\ResourceLinks\Parsers;


use Modules\Product\Services\ResourceLinks\BaseResourceLinkParser;

class DealMedParser extends BaseResourceLinkParser
{
    public int $currencyId = 1;

    protected function getPriceXpath(): string
    {
        return '//*[@id="content"]/div/div[1]/div/span/span[1]';
    }

    protected function getAvailabilityXpath(): string
    {
        return '//*[@id="content"]/div/div[1]/div/div[3]/span';
    }
}
