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

    /**
     * @throws \Exception
     */
    public function getPrice(): int
    {
        if (!is_null($this->getPriceXpath())) {
            return parent::getPrice();
        }

        $price = $this->document->xpath("//div[contains(@class, 'ordcen')]")[0]
            ?->first('.price')
            ?->first('.price-value::text()');

        if (is_null($price)) {
            throw new \Exception('');
        }

        $price = $this->baseParseService->removeWhiteSpace($price, true);

        return (int)$price;
    }

    /**
     * @throws \Exception
     */
    public function getAvailability(): Availability
    {
        if (!is_null($this->getAvailabilityXpath())) {
            return parent::getAvailability();
        }

        $availability = $this->document->xpath(
            "//div[contains(@class, 'ordcen')]"
        )[0]
            ?->first('.stock-on-product-card-info-block')
            ?->first('span.stock::text()');

        if (is_null($availability)) {
            throw new \Exception('');
        }

        $availability = $this->baseParseService->removeWhiteSpace($availability);

        $availabilityEnum = $this->matchAvailability($availability);

        if (!is_null($availabilityEnum)) {
            return $availabilityEnum;
        }

        throw new \Exception('');
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
