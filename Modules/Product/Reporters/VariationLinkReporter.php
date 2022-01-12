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
        $productIds = \DB::table('variation_links as vl')
            ->select(['vl.id', 'vl.supplier', 'pv.name as variation_name', 'pv.product_id'])
            ->join('product_variations as pv', 'pv.id', '=', 'vl.product_variation_id')
            ->whereIn('vl.id', $this->reports->pluck('id'))
            ->get()
            ->map(fn(object $object): array => (array)$object);

        $withProductIds = $this->reports->map(function (array $report) use ($productIds) {
            $productIdData = $productIds
                ->where('id', $report['id'])
                ->first();

            $report['product_id'] = $productIdData['product_id'];
            $report['supplier'] = $productIdData['supplier'];
            $report['variation_name'] = $productIdData['variation_name'];

            return $report;
        });

        $sortedReports = $withProductIds->sortBy(['product_id', 'id', 'supplier', 'type']);

        \Mail::to(config('product.variation-link.reports.email'))
            ->queue(new VariationLinkReportsNotify($sortedReports));
    }
}
