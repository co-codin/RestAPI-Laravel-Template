<?php


namespace Modules\Product\Services\ResourceLinks\Parsers;


use Modules\Product\Enums\Availability;

class MedComplexParser extends BaseResourceLinkParser
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

        $price = $this->document->xpath(
            "//div[contains(@class, 'price-card-body_price')]"
            . "/div[contains(@class, 'pr_block_group')]"
        )[0]
            ?->first('.price_block')
            ?->first('span::text()');

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
            "//div[contains(@class, 'price-card-body_price')]"
            . "/div[contains(@class, 'product-status')]"
        )[0]
            ?->first('.product-where::text()');

        if (is_null($availability)) {
            $this->availabilityReport('Не найдено наличие на странице');
            throw new \Exception('Не найдено наличие на странице');
        }

        $availability = $this->baseParseService->removeWhiteSpace($availability);

        $availabilityEnum = $this->matchAvailability($availability);

        if (is_null($availabilityEnum)) {
            $this->availabilityReport(
                "Значение наличия не прошло проверку.",
                "Наличие на странице: $availability"
            );

            throw new \Exception('Значение наличия не прошло проверку');
        }

        return $availabilityEnum;
    }

    protected function matchAvailability(string $availability): ?Availability
    {
        return match (\Str::lower($availability)) {
            'в наличии' => Availability::IN_STOCK(),
            'ожидается поставка' => Availability::COMING_SOON(),
            default => null
        };
    }
}
