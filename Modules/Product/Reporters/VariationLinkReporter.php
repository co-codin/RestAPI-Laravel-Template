<?php

namespace Modules\Product\Reporters;

use Illuminate\Support\Collection as SupportCollection;
use JetBrains\PhpStorm\ArrayShape;
use Modules\Form\Mail\VariationLinkReportsNotify;
use Modules\Product\Enums\VariationLinkReportType;

class VariationLinkReporter
{
    private SupportCollection $reports;

    public function __construct()
    {
        $this->reports = collect([]);
    }

    public function setReport(int $variationLinkId, VariationLinkReportType $reportType, string $message): void
    {
        $this->reports->push([
            'id' => $variationLinkId,
            'type' => $reportType->value,
            'message' => $message
        ]);
    }

    #[ArrayShape([
        'id' => "int",
        'type' => "int",
        'message' => "string",
    ])]
    public function getReport(int $variationLinkId): ?array
    {
        return $this->reports->where('id', $variationLinkId)->first();
    }

    public function getReports(): SupportCollection
    {
        return $this->reports;
    }

    public function sendReports(): void
    {
        \Mail::to(config('product.variation-link.reports.email'))
            ->queue(new VariationLinkReportsNotify($this->reports));
    }
}
