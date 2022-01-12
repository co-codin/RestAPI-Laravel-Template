<?php

namespace Modules\Product\Services\ResourceLinks;

use Modules\Product\Enums\Availability;
use Modules\Product\Enums\VariationLinkReportType;
use Modules\Product\Models\VariationLink;
use Modules\Product\Reporters\VariationLinkReporter;

abstract class BaseResourceLink
{
    abstract public function getPrice(): int;

    abstract public function getAvailability(): Availability;

    public function __construct(
        protected VariationLink $variationLink,
    ) {}

    public function getCurrencyId(): int
    {
        return 1;
    }

    protected function statusCodeReport(string $message, string $comment = ''): void
    {
        $this->report(VariationLinkReportType::STATUS_CODE(), $message, $comment);
    }

    protected function checkReport(string $message, string $comment = ''): void
    {
        $this->report(VariationLinkReportType::CHECK(), $message, $comment);
    }

    protected function priceReport(string $message, string $comment = ''): void
    {
        $this->report(VariationLinkReportType::PRICE(), $message, $comment);
    }

    protected function availabilityReport(string $message, string $comment = ''): void
    {
        $this->report(VariationLinkReportType::AVAILABILITY(), $message, $comment);
    }

    protected function doneReport(string $message, string $comment = ''): void
    {
        $this->report(VariationLinkReportType::DONE(), $message, $comment);
    }

    protected function report(VariationLinkReportType $reportType, string $message, string $comment = ''): void
    {
        app(VariationLinkReporter::class)->setReport(
            $this->variationLink->id,
            $reportType,
            $message,
            $comment
        );
    }
}
