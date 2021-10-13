<?php


namespace Modules\Export\Services\Generator\Market;


use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Str;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;
use Vitalybaev\GoogleMerchant\Product as GoogleProduct;
use Vitalybaev\GoogleMerchant\Product\Availability\Availability;

class ProductGoogleGeneratorConverter
{
    public function __construct(
        private Product $model
    ) {}

    /**
     * @throws \Vitalybaev\GoogleMerchant\Exception\InvalidArgumentException
     */
    public function toXml(): GoogleProduct
    {
        $item = new GoogleProduct();

        $item
            ->setId($this->getId())
            ->setTitle($this->getName())
            ->setDescription($this->getShortDescription())
            ->setLink($this->getLink())
            ->setImage($this->getImageLink())
            ->setAvailability($this->getAvailability())
            ->setProductType($this->getProductType())
            ->setPrice($this->getPrice())
            ->setBrand($this->getBrandName())
            ->setGoogleCategory($this->getCategories())
            ->setCondition($this->getCondition())
            ->setGtin($this->getGtin());

        if ($this->getAdditionalImages()) {
            foreach ($this->getAdditionalImages() as $image) {
                if ($image->image) {
                    $item->setAdditionalImage($image->image);
                }
            }
        }

        return $item;
    }

    private function getId(): int
    {
        return $this->model->id;
    }

    private function getCategories(): string
    {
        return $this->getCategoryAncestorsName()
            ->join(' > ');
    }

    private function getName(): string
    {
        return $this->model->name . ' ' . $this->model->name;
    }

    private function getShortDescription(): string
    {
        return $this->model->short_description ?? '';
    }

    private function getLink(): string
    {
        return config('app.site_url') . "/product/{$this->model->slug}/{$this->model->id}";
    }

    private function getImageLink(): string
    {
        return !is_null($this->model->image) ? config('app.storage_url') . $this->model->image : '';
    }

    private function getAvailability(): string
    {
        return Availability::IN_STOCK;
//        return $this->getVariationPresenter()->in_stock === ProductVariationStock::InStock
//            ? Availability::IN_STOCK
//            : Availability::OUT_OF_STOCK;
    }

    private function getProductVariation(): ProductVariation
    {
        return $this->model->productVariations->first();
    }

    private function getPrice(): string
    {
        $productVariation = $this->getProductVariation();

        return $productVariation->price . ' ' . Str::upper($productVariation->currency->iso_code);
    }

    private function getBrandName(): string
    {
        return $this->model->brand->name;
    }

    private function getCondition(): string
    {
        return 'new';
    }

    private function getGtin(): bool
    {
        return false;
    }

    private function getAdditionalImages(): SupportCollection
    {
        return $this->model->images->count() ? $this->model->images : collect([]);
    }

    private function getCategoryAncestorsName(): SupportCollection
    {
        return $this->model->category->ancestors
            ->add($this->model->category)
            ->pluck('name');
    }

    private function getProductType(): string
    {
        return $this->getCategoryAncestorsName()
            ->prepend('Главная')
            ->join(' > ');
    }
}
