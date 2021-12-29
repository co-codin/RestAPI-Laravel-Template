<?php

namespace Modules\Product\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Modules\Product\Enums\SupplierEnum;
use Modules\Product\Models\VariationLink;
use Modules\Product\Services\ResourceLinks\BaseResourceLink;

class ProductVariationLinkCommand extends Command
{
    protected $signature = 'variation-data:update';

    protected $description = 'Variation data to variation links update';

    public function handle(): void
    {
        $variationLinks = $this->getVariationLinks();

        foreach ($variationLinks as $variationLink) {
            $service = $this->getResourceService($variationLink);
            dd(
                $service->getAvailability(),
                $service->getPrice(),
                $variationLink->id
            );
        }
    }

    /**
     * @return Collection|VariationLink[]
     */
    private function getVariationLinks(): Collection
    {
        return VariationLink::query()
            ->whereExists(function (Builder $query) {
                $query
                    ->select('pv.is_update_from_links')
                    ->from('product_variations as pv')
                    ->whereColumn('pv.id', 'variation_links.product_variation_id')
                    ->where('pv.is_update_from_links', true);
            })
            ->get();
    }

    private function getResourceService(VariationLink $variationLink): BaseResourceLink
    {
        $class = SupplierEnum::$resourceServices[$variationLink->supplier];

        return new $class($variationLink);
    }
}
