<?php


namespace Modules\Product\Repositories\Criteria;


use App\Http\Filters\LiveFilter;
use Modules\Brand\Repositories\Criteria\BrandRequestCriteria;
use Modules\Category\Repositories\Criteria\CategoryRequestCriteria;
use Modules\Product\Http\Filters\CovidProductsFilter;
use Modules\Product\Http\Filters\ProductPropertyFilter;
use Modules\Property\Repositories\Criteria\PropertyRequestCriteria;
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

                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'name' => 'like',
                ])),

                AllowedFilter::custom('properties', new ProductPropertyFilter),
                AllowedFilter::custom('is_covid', new CovidProductsFilter),

                AllowedFilter::trashed(),

                AllowedFilter::exact('categories.id'),
                AllowedFilter::callback('categories.is_main', function ($query, $value) {
                    $query->whereHas('productCategories', function ($q) use ($value) {
                        $q->where('is_main', (bool)$value);
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
            ])
            ->allowedIncludes([
                'brand',
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
            ->allowedSorts('id', 'name', 'warranty', 'created_at', 'updated_at', 'deleted_at')
            ;
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
