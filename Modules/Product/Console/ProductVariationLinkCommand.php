<?php

namespace Modules\Product\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Modules\Product\Enums\SupplierEnum;
use Modules\Product\Models\VariationLink;
use Modules\Product\Services\ResourceLinks\BaseResourceLink;

class ProductVariationLinkCommand extends Command
{
    protected $signature = 'variation-data:update';

    protected $description = 'Variation data to variation links update';

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        $variationLinks = VariationLink::query()->with('productVariation')->get();

        foreach ($variationLinks as $variationLink) {
            $service = $this->getResourceService($variationLink);

            $variationLink->currency_id = $service->getCurrencyId();
            $variationLink->price = $service->getPrice();
            $variationLink->availability = $service->getAvailability()->value;
            $variationLink->info_updated_at = Carbon::now()->toDateTimeString();

            if (!$variationLink->save()) {
                throw new \Exception('');
            }

            if ($variationLink->productVariation->is_update_from_links && $variationLink->is_default) {
                $variationLink->productVariation->update([
                    'currency_id' => $variationLink->currency_id,
                    'price' => $variationLink->price,
                    'availability' => $variationLink->availability,
                ]);
            }
        }
    }

    private function getResourceService(VariationLink $variationLink): BaseResourceLink
    {
        $class = SupplierEnum::$resourceServices[$variationLink->supplier];

        return new $class($variationLink);
    }
}
