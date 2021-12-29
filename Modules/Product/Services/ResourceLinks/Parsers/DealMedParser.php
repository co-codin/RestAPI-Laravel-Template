<?php


namespace Modules\Product\Services\ResourceLinks\Parsers;


use Modules\Product\Enums\Availability;
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

    protected function matchAvailability(string $availability): ?Availability
    {
        return match (true) {
            str_contains($availability, 'В наличии') => Availability::IN_STOCK(),
            $availability === '' => Availability::UNDER_THE_ORDER(),
            str_contains($availability, 'Ожидается поставка') => Availability::COMING_SOON(),
            default => null
        };
    }
}
