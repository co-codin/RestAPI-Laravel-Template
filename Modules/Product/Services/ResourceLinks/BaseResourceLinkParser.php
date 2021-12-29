<?php

namespace Modules\Product\Services\ResourceLinks;

use App\Services\Parse\BaseParse;
use DiDom\Document;
use Modules\Product\Enums\Availability;
use Modules\Product\Models\VariationLink;

abstract class BaseResourceLinkParser extends BaseResourceLink
{
    private Document $document;
    private BaseParse $baseParseService;

    abstract protected function getPriceXpath(): string;
    abstract protected function getAvailabilityXpath(): string;

    public function __construct(protected VariationLink $variationLink)
    {
        $this->baseParseService = new BaseParse();
        $this->document = $this->baseParseService->getDocument($variationLink->resource);
    }

    public function getPrice(): int
    {
        $price = $this->document->xpath("{$this->getPriceXpath()}/text()");

        if (count($price) !== 1) {
            throw new \Exception('');
        }

        $price = $this->baseParseService->removeWhiteSpace($price[0], true);

        return (int)$price;
    }

    public function getAvailability(): Availability
    {
        $availability = $this->document->xpath("{$this->getAvailabilityXpath()}/text()");

        if (count($availability) !== 1) {
            throw new \Exception('');
        }

        $availability = $this->baseParseService->removeWhiteSpace($availability[0]);

        return $this->matchAvailability($availability);
    }

    protected function matchAvailability(string $inStock): Availability
    {
        return match ($inStock) {
            'В наличии' => Availability::IN_STOCK(),
            '' => Availability::UNDER_THE_ORDER(),
            'Ожидается поставка' => Availability::COMING_SOON(),
//            '' => Availability::OUT_OF_PRODUCTION(),
//            '' => Availability::MISSING_REG_CERTIFICATE(),
            default => throw new \Exception('')
        };
    }
}
