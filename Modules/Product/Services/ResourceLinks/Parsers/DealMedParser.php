<?php


namespace Modules\Product\Services\ResourceLinks\Parsers;


use Modules\Product\Enums\Availability;

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
            return $this->getPriceByXpath();
        }

        $price = $this->document->xpath("//div[contains(@class, 'ordcen')]")[0]
            ?->first('.price')
            ?->first('.price-value::text()');

        if (is_null($price)) {
            $this->priceReport('Не найдена цена на странице');
            throw new \Exception('Не найдена цена на странице');
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
            return $this->getAvailabilityByXpath();
        }

        $availability = $this->document->xpath(
            "//div[contains(@class, 'ordcen')]"
        )[0]
            ?->first('.stock-on-product-card-info-block')
            ?->first('span.stock::text()');

        if (is_null($availability)) {
            $this->availabilityReport('Не найдено наличие на странице');
            throw new \Exception('Не найдено наличие на странице');
        }

        $availability = $this->baseParseService->removeWhiteSpace($availability);

        $availabilityEnum = $this->matchAvailability($availability);

        if (is_null($availabilityEnum)) {
            $this->availabilityReport("Значение наличия не прошло проверку. Наличие на странице: $availability");
            throw new \Exception("Значение наличия не прошло проверку. Наличие на странице: $availability");
        }

        return $availabilityEnum;
    }

    protected function matchAvailability(string $availability): ?Availability
    {
        $availability = \Str::lower($availability);

        return match (true) {
            str_contains($availability, 'в наличии') => Availability::IN_STOCK(),
            str_contains($availability, 'ожидается поставка') => Availability::COMING_SOON(),
            default => null
        };
    }
}
