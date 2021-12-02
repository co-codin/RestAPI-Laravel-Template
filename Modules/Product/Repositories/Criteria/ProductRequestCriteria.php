<?php


namespace Modules\Product\Repositories\Criteria;


use App\Filters\ContentFilter;
use App\Filters\IsEmptyFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Brand\Repositories\Criteria\BrandRequestCriteria;
use Modules\Category\Repositories\Criteria\CategoryRequestCriteria;
use Modules\Product\Http\Filters\CovidProductsFilter;
use Modules\Product\Http\Filters\ProductPropertyFilter;
use Modules\Property\Repositories\Criteria\PropertyRequestCriteria;
use Modules\Review\Repositories\Criteria\ProductReviewRequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $includes = request()->input('include') ?? [];

        if(is_string($includes)) {
            $includes = explode(",", $includes);
        }

        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                static::allowedProductFields(),
                static::allowedProductVariationFields('product_variations'),
                static::allowedProductVariationFields('main_variation'),
                BrandRequestCriteria::allowedBrandFields('brand'),
                CategoryRequestCriteria::allowedCategoryFields('category'),
                CategoryRequestCriteria::allowedCategoryFields('categories'),
                PropertyRequestCriteria::allowedPropertyFields('properties'),
                ProductReviewRequestCriteria::allowedProductReviewFields('product_reviews'),
                [
                    'images.id',
                    'images.image',
                    'images.caption',
                    'images.position',
                ],
            ))
            ->when(in_array("mainVariation", $includes), fn($query) => $query->withMainVariation())
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('slug'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('brand_id'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('image'),
                AllowedFilter::exact('is_in_home'),
                AllowedFilter::exact('warranty'),
                AllowedFilter::partial('short_description'),
                AllowedFilter::partial('full_description'),

                AllowedFilter::callback('live', function (Builder $query, $value) {
                    $query->selectRaw('products.id as id, CONCAT(b.name, " ", products.name) as name')
                        ->join('brands as b', 'b.id', '=', 'products.brand_id');

                    $query->where('products.name', 'like', "%$value%")
                        ->orWhere('products.id', '=', $value)
                        ->orWhere('b.name', 'like', "%$value%")
                    ;

                }),

                AllowedFilter::custom('has_video', new IsEmptyFilter('video')),
                AllowedFilter::custom('has_booklet', new IsEmptyFilter('booklet')),

                AllowedFilter::custom('properties', new ProductPropertyFilter),
                AllowedFilter::custom('is_covid', new CovidProductsFilter),

                AllowedFilter::trashed(),

                AllowedFilter::exact('categories.id'),
                AllowedFilter::callback('categories.parent_category_id', function ($query, $value) {
                    $query->whereHas('productCategories', function ($q) use ($value) {
                        $q->where('is_main', true)
                            ->where('category_id', $value);
                    });
                }),

                AllowedFilter::exact('productVariations.id'),
                AllowedFilter::partial('productVariations.name'),
                AllowedFilter::exact('productVariations.is_price_visible'),
                AllowedFilter::exact('productVariations.is_enabled'),
                AllowedFilter::exact('productVariations.currency_id'),
                AllowedFilter::exact('productVariations.price'),
                AllowedFilter::exact('productVariations.availability'),
                AllowedFilter::exact('productVariations.previous_price'),

                AllowedFilter::exact('productReviews.status'),
                AllowedFilter::exact('productReviews.is_confirmed'),

                AllowedFilter::custom('unique_content', new ContentFilter('product')),
                AllowedFilter::custom('no_unique_content', new ContentFilter('product', true)),
            ])
            ->allowedIncludes([
                'brand',
                'productReviews',
                'productVariations',
                'productVariations.currency',
                'properties',
                'category',
                'categories',
                'seo',
                'images',
                'mainVariation',
                'mainVariation.currency',
                'stockType',
            ])
            ->allowedSorts('id', 'name', 'warranty', 'created_at', 'updated_at', 'deleted_at');
    }

    public static function allowedProductFields($prefix = null)
    {
        $fields = [
            'id',
            'slug',
            'status' ,
            'name',
            'image',
            'position',
            'brand_id',
            'stock_type_id',
            'is_enabled',
            'warranty',
            'warranty_info',
            'group_id',
            'short_description',
            'full_description',
            'created_at',
            'updated_at',
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }

    public static function allowedProductVariationFields($prefix = null): array
    {
        $fields = [
            'id',
            'product_id',
            'name',
            'price' ,
            'previous_price',
            'currency_id',
            'is_price_visible',
            'is_enabled',
            'availability',
            'condition_id',
            'created_at',
            'updated_at'
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }
}
