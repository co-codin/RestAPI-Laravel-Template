<?php

namespace Modules\Product\Reporters;

use Illuminate\Support\Collection as SupportCollection;
use JetBrains\PhpStorm\ArrayShape;
use Modules\Form\Mail\VariationLinkReportsNotify;
use Modules\Product\Dto\VariationLinkReportDto;
use Modules\Product\Dto\VariationLinkReportDtoCollection;
use Modules\Product\Enums\SupplierEnum;
use Modules\Product\Enums\VariationLinkReportType;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class VariationLinkReporter
{
    private VariationLinkReportDtoCollection $reports;

    public function __construct()
    {
        $this->reports = new VariationLinkReportDtoCollection([]);
    }

    /**
     * @throws UnknownProperties
     */
    public function setReport(
        int $variationLinkId,
        VariationLinkReportType $reportType,
        string $message,
        string $comment = ''
    ): void
    {
        $this->reports->push(
            VariationLinkReportDto::create([
                'id' => $variationLinkId,
                'type' => $reportType,
                'message' => $message,
                'comment' => $comment
            ])
        );
    }

    public function getReport(int $variationLinkId): ?VariationLinkReportDto
    {
        return $this->reports->where('id', $variationLinkId)->first();
    }

    public function getReports(): VariationLinkReportDtoCollection
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

        $withProductIds = $this->reports->map(function (VariationLinkReportDto $report) use ($productIds): VariationLinkReportDto {
            $productIdData = $productIds
                ->where('id', $report->id)
                ->first();

            $report->productId = $productIdData['product_id'];
            $report->supplier = SupplierEnum::fromValue($productIdData['supplier']);
            $report->variationName = $productIdData['variation_name'];

            return $report;
        });

        $sortedReports = $withProductIds->sortBy(['productId', 'id', 'supplier.value', 'type.value']);

        \Mail::to(config('product.variation-link.reports.email'))
            ->queue(new VariationLinkReportsNotify($sortedReports));
    }
}
