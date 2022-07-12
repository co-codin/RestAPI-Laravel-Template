<?php

namespace Modules\Product\Repositories\Criteria;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ProductFavoritePageCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select([
                'id', 'name', 'article', 'short_description', 'image', 'slug', 'brand_id',
            ])
            ->with(['category' => function ($query) {
                $query->addSelect('id', 'name', 'parent_id');
            }])
            ->with(['brand' => function ($query) {
                    $query->addSelect('id', 'name');
            }])
            ->with([
                'properties' => function ($query) {
                    $query
                        ->addSelect('name', 'description')
                    ;
                }
            ])
            ->with([
                'productVariations' => function ($query) {
                    $query
                        ->addSelect(
                            'id', 'name', 'price', 'previous_price', 'is_price_visible', 'currency_id'
                        )
                        ->with([
                            'currency' => function ($query) {
                                $query->addSelect('id', 'rate');
                            }
                        ])
                    ;
                }
            ])
            ->with([
                'images' => function ($query) {
                    $query->addSelect('imageable_id', 'image');
                }
            ])
            ;
    }
}
