<?php


namespace Modules\Product\Services\ResourceLinks\Parsers;


use Modules\Product\Services\ResourceLinks\BaseResourceLinkParser;

class MedComplexParser extends BaseResourceLinkParser
{
    public int $currencyId = 1;

    protected function getPriceXpath(): string
    {
        return '/html/body/div[1]/section/div/div[2]/div[3]/div[1]/div/div[1]/div[1]/div[2]/div[1]/div[1]/div/span[1]';
    }

    protected function getAvailabilityXpath(): string
    {
        return '/html/body/div[1]/section/div/div[2]/div[3]/div[1]/div/div[1]/div[1]/div[1]/noindex/div';
    }
}
