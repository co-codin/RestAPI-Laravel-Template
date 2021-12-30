<?php

namespace Modules\Product\Services\ResourceLinks\Parsers;

use App\Services\Parse\BaseParse;
use DiDom\Document;
use Modules\Product\Enums\Availability;
use Modules\Product\Models\VariationLink;
use Modules\Product\Services\ResourceLinks\BaseResourceLink;

abstract class BaseResourceLinkParser extends BaseResourceLink
{
    protected Document $document;
    protected VariationLink $variationLink;
    protected BaseParse $baseParseService;

    abstract protected function matchAvailability(string $availability): ?Availability;

    /**
     * @throws \Exception
     */
    public function __construct(VariationLink $variationLink)
    {
        $this->checkLinkResource($variationLink);

        $this->baseParseService = new BaseParse();
        $this->variationLink = $variationLink;
        $this->document = $this->baseParseService->getDocument($variationLink->resource);
    }

    /**
     * @throws \Exception
     */
    protected function getPriceByXpath(): int
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
    protected function getAvailabilityByXpath(): Availability
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

    protected function getPriceXpath(): ?string
    {
        return \Arr::get($this->variationLink->xpath, 'price');
    }

    protected function getAvailabilityXpath(): ?string
    {
        return \Arr::get($this->variationLink->xpath ,'availability');
    }

    /**
     * @throws \Exception
     */
    private function checkLinkResource(VariationLink $variationLink): void
    {
        $response = \Http::get($variationLink->resource);

        if ($response->successful()) {
            return;
        }

        $message = match (true) {
            $response->serverError() => 'Ошибка сервера на странице',
            $response->clientError() => 'Страница не найдена',
            $response->redirect() => 'Ссылка содержит редирект',
            default => "Страница недоступна. Код ответа: {$response->status()}"
        };

        throw new \Exception($message);
    }
}
