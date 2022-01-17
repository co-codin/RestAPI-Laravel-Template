<?php

namespace Modules\Product\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Product\Enums\SupplierEnum;
use Modules\Product\Enums\VariationLinkReportType;
use Modules\Product\Models\VariationLink;
use Modules\Product\Reporters\VariationLinkReporter;
use Modules\Product\Services\ResourceLinks\BaseResourceLink;

class ProductVariationLinkCommand extends Command
{
    protected $signature = 'variation-data:update';

    protected $description = 'Variation data to variation links update';

    public function handle(VariationLinkReporter $variationLinkReporter): void
    {
        $variationLinks = VariationLink::query()->with('productVariation')->get();

        foreach ($variationLinks as $variationLink) {
            try {
                $resourceService = $this->getResourceService($variationLink);

                $this->variationLinkUpdate($resourceService, $variationLink);
                $this->productVariationUpdate($variationLink);
            } catch (\Throwable $e) {
                continue;
            }
        }

        $variationLinkReporter->sendReports();
    }

    private function getResourceService(VariationLink $variationLink): BaseResourceLink
    {
        /** @var string $class */
        $class = SupplierEnum::$resourceServices[$variationLink->supplier];

        return app($class, ['variationLink' => $variationLink]);
    }

    /**
     * @throws \Exception
     */
    private function variationLinkUpdate(BaseResourceLink $resourceService, VariationLink $variationLink): void
    {
        $variationLink->currency_id = $resourceService->getCurrencyId();
        $variationLink->price = $resourceService->getPrice();
        $variationLink->availability = $resourceService->getAvailability()->value;
        $variationLink->info_updated_at = Carbon::now()->toDateTimeString();

        if (!$variationLink->save()) {
            app(VariationLinkReporter::class)->setReport(
                $variationLink->id,
                VariationLinkReportType::VARIATION_LINK_UPDATE(),
                'Ошибка при обновлении связи'
            );

            throw new \Exception('Ошибка при обновлении связи');
        }
    }

    /**
     * @throws \Exception
     */
    private function productVariationUpdate(VariationLink $variationLink): void
    {
        if ($variationLink->productVariation->is_update_from_links && $variationLink->is_default) {
            $productVariationData = [
                'currency_id' => $variationLink->currency_id,
                'price' => $variationLink->price,
                'availability' => $variationLink->availability,
            ];

            if (!$variationLink->productVariation->update($productVariationData)) {
                app(VariationLinkReporter::class)->setReport(
                    $variationLink->id,
                    VariationLinkReportType::PRODUCT_VARIATION_UPDATE(),
                    'Ошибка при обновлении модификации'
                );

                throw new \Exception('Ошибка при обновлении модификации');
            }
        }
    }
}
