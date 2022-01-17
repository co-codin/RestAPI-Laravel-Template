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
    protected BaseParse $baseParseService;

    abstract protected function matchAvailability(string $availability): ?Availability;

    /**
     * @throws \Exception
     */
    public function __construct(VariationLink $variationLink)
    {
        parent::__construct($variationLink);

        $this->baseParseService = new BaseParse();
        $this->checkLinkResource();
        $this->document = $this->baseParseService->getDocument($variationLink->resource);
    }

    /**
     * @throws \Exception
     */
    protected function getPriceByXpath(): int
    {
        $price = $this->document->xpath($this->getPriceXpath() . '/text()');

        if (empty($price)) {
            $this->priceReport('Не найдена цена на странице');
            throw new \Exception('Не найдена цена на странице');
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
            $this->availabilityReport('Не найдено наличие на странице');
            throw new \Exception('Не найдено наличие на странице');
        }

        foreach ($availability as $item) {
            $item = $this->baseParseService->removeWhiteSpace($item);
            $availabilityEnum = $this->matchAvailability($item);

            if (!is_null($availabilityEnum)) {
                return $availabilityEnum;
            }
        }

        $this->availabilityReport(
            "Значение наличия не прошло проверку.",
            "Наличие на странице:" . implode(', ', $availability)
        );

        throw new \Exception('Значение наличия не прошло проверку');
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
    private function checkLinkResource(): void
    {
        $response = \Http::get($this->variationLink->resource);

        if ($response->successful()) {
            return;
        }

        switch (true) {
            case $response->serverError():
                $message = "Ошибка сервера на странице";
                break;
            case $response->clientError():
                $message = "Страница не найдена";
                break;
//            case $response->redirect() || ($variationLink->resource !== (string)$response->effectiveUri()): {
            case $response->redirect():
            {
                $message = "Ссылка содержит редирект.";
                $comment = "Указанная ссылка: {$this->variationLink->resource}."
                . " Конечная ссылка: " . $response->effectiveUri();
            }
                break;
            default: {
                $message = "Страница недоступна.";
                $comment = "Код ответа: {$response->status()}";
            }
                break;
        }

        $this->statusCodeReport($message, $comment ?? '');
        throw new \Exception($message);
    }
}
