<?php

namespace Modules\Product\Services\ResourceLinks;

use Modules\Product\Enums\Availability;
use Modules\Product\Enums\VariationLinkReportType;
use Modules\Product\Models\VariationLink;
use Modules\Product\Reporters\VariationLinkReporter;

abstract class BaseResourceLink
{
    abstract public function getCurrencyId(): int;

    abstract public function getPrice(): int;

    abstract public function getAvailability(): Availability;

    public function __construct(
        protected VariationLink $variationLink,
    ) {}

    protected function statusCodeReport(string $message): void
    {
        $this->report(VariationLinkReportType::STATUS_CODE(), $message);
    }

    protected function checkReport(string $message): void
    {
        $this->report(VariationLinkReportType::CHECK(), $message);
    }

    protected function priceReport(string $message): void
    {
        $this->report(VariationLinkReportType::PRICE(), $message);
    }

    protected function availabilityReport(string $message): void
    {
        $this->report(VariationLinkReportType::AVAILABILITY(), $message);
    }

    protected function doneReport(string $message): void
    {
        $this->report(VariationLinkReportType::DONE(), $message);
    }

    protected function report(VariationLinkReportType $reportType, string $message): void
    {
        app(VariationLinkReporter::class)->setReport(
            $this->variationLink->id,
            $reportType,
            $message
        );
    }
}
