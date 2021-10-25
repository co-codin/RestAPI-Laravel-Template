<?php


namespace Modules\Export\Services\Generators\GoogleMerchant;


use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Str;
use Modules\Product\Models\Product;
use Vitalybaev\GoogleMerchant\Product as GoogleProduct;
use Vitalybaev\GoogleMerchant\Product\Availability\Availability;

class ProductGoogleGeneratorConverter
{
    public function __construct(
        private Product $model
    ) {}

    public function toXml(): GoogleProduct
    {
        $item = (new GoogleProduct())
            ->setId($this->model->id)
            ->setTitle($this->model->brand->name . ' ' . $this->model->name)
            ->setDescription($this->model->short_description ?? '')
            ->setLink($this->model->siteUrl)
            ->setImage(\Storage::disk('public')->url($this->model->image))
            ->setAvailability(Availability::IN_STOCK)
            ->setProductType($this->model->category->product_name)
            ->setPrice($this->getPrice())
            ->setBrand($this->model->brand->name)
            ->setGoogleCategory($this->getCategories())
            ->setCondition('new')
            ->setGtin(false);

        $this->getAdditionalImages()
            ->each(fn($image) => $item->addAdditionalImage($image));

        return $item;
    }

    private function getCategories(): string
    {
        return $this->model->category->ancestors
            ->add($this->model->category)
            ->pluck('name')
            ->join(' > ');
    }

    private function getPrice(): string
    {
        return $this->model->mainVariation->price . ' ' . Str::upper($this->model->mainVariation->currency->iso_code);
    }

    private function getAdditionalImages(): SupportCollection
    {
        return $this->model->images
            ->map(fn($image) => \Storage::disk('public')->url($image->image));
    }
}
