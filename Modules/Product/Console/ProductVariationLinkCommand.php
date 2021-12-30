<?php

namespace Modules\Product\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Modules\Product\Enums\SupplierEnum;
use Modules\Product\Models\VariationLink;
use Modules\Product\Reporters\VariationLinkReporter;
use Modules\Product\Services\ResourceLinks\BaseResourceLink;

class ProductVariationLinkCommand extends Command
{
    protected $signature = 'variation-data:update';

    protected $description = 'Variation data to variation links update';

    /**
     * @throws \Exception
     */
    public function handle(VariationLinkReporter $variationLinkReporter): void
    {
        $variationLinks = VariationLink::query()->with('productVariation')->get();

        foreach ($variationLinks as $variationLink) {
            try {
                $service = $this->getResourceService($variationLink);

                $variationLink->currency_id = $service->getCurrencyId();
                $variationLink->price = $service->getPrice();
                $variationLink->availability = $service->getAvailability()->value;
                $variationLink->info_updated_at = Carbon::now()->toDateTimeString();

                if (!$variationLink->save()) {
                    throw new \Exception('Ошибка при обновлении связи');
                }

                if ($variationLink->productVariation->is_update_from_links && $variationLink->is_default) {
                    if (!$variationLink->productVariation->update([
                        'currency_id' => $variationLink->currency_id,
                        'price' => $variationLink->price,
                        'availability' => $variationLink->availability,
                    ])) {
                        throw new \Exception('Ошибка при обновлении модификации');
                    }
                }
            } catch (\Throwable $e) {
                $variationLinkReporter->setReport($variationLink->id, $e->getMessage());
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
}
