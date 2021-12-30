<?php

namespace Modules\Product\Reporters;

use Illuminate\Support\Collection as SupportCollection;

class VariationLinkReporter
{
    private SupportCollection $reports;

    public function __construct()
    {
        $this->reports = collect([]);
    }

    public function setReport(int $variationLinkId, string $message): void
    {
        $this->reports->push([
            'id' => $variationLinkId,
            'message' => $message
        ]);
    }

    public function getReport(int $variationLinkId): ?string
    {
        return $this->reports->where('id', $variationLinkId)->first();
    }

    public function getReports(): SupportCollection
    {
        return $this->reports;
    }

    public function sendReports(): void
    {
        $done = false;

        if ($this->reports->isEmpty()) {
            $done = true;
        }

//        (new VariationLinkReportsNotify())->dispatch($this->reports, $done);
    }
}
