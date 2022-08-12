<?php


namespace Modules\Product\Services;


use App\Models\Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\Product;

class ProductImageStorage
{
    protected Product $product;

    protected Collection $images;

    public function update(Product $product, array $images = [])
    {
        activity()
            ->performedOn($product)
            ->event('updated')
            ->withProperties([
                'type' => 'image',
                'old' => $product->analogs,
                'new' => $images,
            ])
        ;

        DB::beginTransaction();

        $this->product = $product;
        $this->images = collect($images);

        $this
            ->deleteNonExistentImages()
            ->createNewImages()
            ->updateExistingImages();

        DB::commit();
    }

    public function deleteNonExistentImages()
    {
        $ids = $this->images->pluck('id')->filter()->unique();

        $this->product->images()
            ->when($ids->isNotEmpty(), fn($query) => $query->whereNotIn('id', $ids))
            ->delete();

        return $this;
    }

    public function createNewImages()
    {
        $newImages = $this->images->filter(fn($item) => !Arr::exists($item, 'id'));

        $this->product->images()->createMany($newImages);

        return $this;
    }

    public function updateExistingImages()
    {
        $this->images
            ->filter(fn($image) => Arr::exists($image, 'id'))
            ->each(function($image) {
                $model = Image::query()->find($image['id']);
                if($model) {
                    $model->update($image);
                }
            });

        return $this;
    }
}
