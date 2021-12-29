<?php


namespace Modules\Product\Services\ResourceLinks\Parsers;


use Modules\Product\Enums\Availability;
use Modules\Product\Services\ResourceLinks\BaseResourceLinkParser;

class MedComplexParser extends BaseResourceLinkParser
{
    public function getCurrencyId(): int
    {
        return 1;
    }

    protected function getPriceXpath(): ?string
    {
        return $this->variationLink->xpath?->price;
//        return '/html/body/div[1]/section/div/div[2]/div[3]/div[1]/div/div[1]/div[1]/div[2]/div[1]/div[1]/div/span[1]';
    }

    protected function getAvailabilityXpath(): ?string
    {
        return $this->variationLink->xpath?->availability;
//        return '/html/body/div[1]/section/div/div[2]/div[3]/div[1]/div/div[1]/div[1]/div[1]/noindex/div';
    }

    /**
     * @throws \Exception
     */
    public function getPrice(): int
    {
        if (!is_null($this->getPriceXpath())) {
            return self::getPrice();
        }

        $price = $this->document->xpath(
            "//div[contains(@class, 'price-card-body_price')]"
            . "/div[contains(@class, 'pr_block_group')]"
        )[0]
            ?->first('.price_block')
            ?->first('span::text()');

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
        $button = $this->document->xpath("//div[contains(@class, 'price-card-footer')]")[0]
            ?->first('.product-page-buy-button')
            ?->first('.btn::text()');

        if ($button === "Смотреть") {
            return Availability::UNDER_THE_ORDER();
        }

        if (!is_null($this->getAvailabilityXpath())) {
            return self::getAvailability();
        }

        $availability = $this->document->xpath(
            "//div[contains(@class, 'price-card-body_price')]"
            . "/div[contains(@class, 'product-status')]"
        )[0]
            ?->first('.product-where::text()');

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
        return match (\Str::lower($availability)) {
            'в наличии' => Availability::IN_STOCK(),
            '' => Availability::UNDER_THE_ORDER(),
            'ожидается поставка' => Availability::COMING_SOON(),
            default => null
        };
    }
}
