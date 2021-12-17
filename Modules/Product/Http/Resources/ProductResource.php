<?php


namespace Modules\Product\Http\Resources;


use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;
use App\Http\Resources\FieldValueResource;
use Illuminate\Http\Resources\MissingValue;
use Modules\Brand\Http\Resources\BrandResource;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Product\Enums\ProductGroup;
use Modules\Product\Models\Product;
use Modules\Property\Http\Resources\PropertyResource;
use Modules\Review\Enums\ProductReviewStatus;
use Modules\Review\Http\Resources\ProductReviewResource;
use Modules\Review\Models\ProductReview;
use Modules\Seo\Http\Resources\SeoResource;

/**
 * @mixin Product
 */
class ProductResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        $attributes = array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', [
                'value' => $this->status,
                'description' => Status::getDescription($this->status),
            ]),
            'product_variations' => new MissingValue(),
            'main_variation' => new MissingValue(),
            'stock_type' => new MissingValue(),
            'stockType' => new FieldValueResource($this->whenLoaded('stockType')),
            'properties' => PropertyResource::collection($this->whenLoaded('properties')),
            'productVariations' => ProductVariationResource::collection($this->whenLoaded('productVariations')),
            'mainVariation' => new ProductVariationResource($this->whenLoaded('mainVariation')),
            'seo' => new SeoResource($this->whenLoaded('seo')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'product_reviews' => ProductReviewResource::collection($this->whenLoaded('productReviews')),
        ]);

        if ($this->relationLoaded('productReviews')) {
            $attributes = array_merge(
                $attributes,
                ['rating' => $this->rating]
            );
        }

        return $attributes;
    }
}
