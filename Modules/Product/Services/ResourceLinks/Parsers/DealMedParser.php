<?php


namespace Modules\Product\Services\ResourceLinks\Parsers;


use Modules\Product\Enums\Availability;
use Modules\Product\Services\ResourceLinks\BaseResourceLinkParser;

class DealMedParser extends BaseResourceLinkParser
{
    public function getCurrencyId(): int
    {
        return 1;
    }

    protected function getPriceXpath(): ?string
    {
        return '//*[@id="content"]/div/div[1]/div/span/span[1]';
    }

    protected function getAvailabilityXpath(): ?string
    {
        return '//*[@id="content"]/div/div[1]/div/div[3]/span';
    }

    protected function matchAvailability(string $availability): ?Availability
    {
        $availability = \Str::lower($availability);

        return match (true) {
            str_contains($availability, 'в наличии') => Availability::IN_STOCK(),
            $availability === '' => Availability::UNDER_THE_ORDER(),
            str_contains($availability, 'ожидается поставка') => Availability::COMING_SOON(),
            default => null
        };
    }
}
