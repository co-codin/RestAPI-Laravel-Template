<?php


namespace Modules\Export\Services\Generators\Avito;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Export\Models\Export;
use Modules\Export\Services\Generators\FeedGeneratorInterface;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;

class AvitoFeedGenerator implements FeedGeneratorInterface
{
    public function __construct(
        protected ProductRepository $productRepository,
    ) {}

    public function generate(Export|Model $export): void
    {
        $headers = [
            'Id', 'AvitoId', 'AdStatus', 'Category',
            'GoodsType', 'Address', 'Title', 'Description',
            'Condition', 'Price', 'DateBegin', 'DateEnd',
            'AllowEmail', 'ManagerName', 'ContactPhone', 'ContactEmail',
            'ImageNames', 'ImageUrls'
        ];
        
        $file = fopen(storage_path('app/public/feeds/' . $export->filename . '.csv'), 'w+');
        fputcsv($file, $headers);

        $products = $this->productRepository->getProductsForFeed($export->filter)->get();

        foreach ($products as $product) {
            fputcsv($file, [
                $product->id,
                '',
                'Free',
                'Оборудование для бизнеса',
                'Другое',
                '129626, город Москва, проспект Мира, дом 102, корпус 1, этаж 6, к. 6',
                trim($product->category->product_name . ' ' . $product->brand->name . ' ' . $product->name),
                $product->short_description ?? '',
                'Новое',
                $product->mainVariation->is_price_visible ? $product->mainVariation->price_in_rub : '',
                Carbon::now()->format('Y-m-d'),
                '',
                'Да',
                'Айна Багыбекова',
                '84953084307',
                'diewiththesun73@gmail.com',
                $this->getImageNames($product),
                $this->getImageUrls($product),
            ]);
        }
    }

    protected function getImageNames(Product $product)
    {
        $names = [
            basename($product->image),
        ];

        foreach ($product->images as $image) {
            $names[] = basename($image->image);
        }

        return implode(' | ', $names);
    }

    protected function getImageUrls(Product $product)
    {
        $urls = [
            \Storage::disk('public')->url($product->image),
        ];

        foreach ($product->images as $image) {
            $urls[] = \Storage::disk('public')->url($image->image);
        }

        return implode(' | ', $urls);
    }
}
