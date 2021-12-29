<?php


namespace Modules\Product\Services\ResourceLinks\Parsers;


use Modules\Product\Enums\Availability;
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

    /**
     * @throws \Exception
     */
    public function getAvailability(): Availability
    {
        $e = $this->document->xpath('/html/body/div[1]/section/div/div[2]/div[3]/div[1]/div/div[2]/div/div[2]/a/text()');

        if (count($e)) {
            return Availability::UNDER_THE_ORDER();
        }

        return self::getAvailability();
    }

    protected function matchAvailability(string $availability): ?Availability
    {
        return match ($availability) {
            'В наличии' => Availability::IN_STOCK(),
            '' => Availability::UNDER_THE_ORDER(),
            'Ожидается поставка' => Availability::COMING_SOON(),
            default => null
        };
    }
}
