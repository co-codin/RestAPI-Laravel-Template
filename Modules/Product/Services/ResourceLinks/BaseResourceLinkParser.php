<?php

namespace Modules\Product\Services\ResourceLinks;

use App\Services\Parse\BaseParse;
use DiDom\Document;
use Modules\Product\Enums\Availability;
use Modules\Product\Models\VariationLink;

abstract class BaseResourceLinkParser extends BaseResourceLink
{
    protected Document $document;
    protected BaseParse $baseParseService;

    abstract public function getCurrencyId(): int;
    abstract protected function getPriceXpath(): ?string;
    abstract protected function getAvailabilityXpath(): ?string;
    abstract protected function matchAvailability(string $availability): ?Availability;

    public function __construct(protected VariationLink $variationLink)
    {
        $this->baseParseService = new BaseParse();
        $this->document = $this->baseParseService->getDocument($variationLink->resource);
    }

    /**
     * @throws \Exception
     */
    public function getPrice(): int
    {
        $price = $this->document->xpath($this->getPriceXpath() . '/text()');

        if (empty($price)) {
            throw new \Exception('');
        }

        $price = $this->baseParseService->removeWhiteSpace($price[0], true);

        return (int)$price;
    }

    /**
     * @throws \Exception
     */
    public function getAvailability(): Availability
    {
        $availability = $this->document->xpath($this->getAvailabilityXpath() . '/text()');

        if (empty($availability)) {
            throw new \Exception('');
        }

        foreach ($availability as $item) {
            $item = $this->baseParseService->removeWhiteSpace($item);
            $availabilityEnum = $this->matchAvailability($item);

            if (!is_null($availabilityEnum)) {
                return $availabilityEnum;
            }
        }

        throw new \Exception('');
    }
}
