<?php

namespace Modules\Product\Repositories\Criteria;

use App\Enums\Status;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ProductListCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select([
                'id', 'name', 'article', 'image', 'slug', 'group_id', 'brand_id', 'stock_type_id'
            ])
            ->joinMainVariation()
            ->with([
                'brand' => function ($query) {
                    $query->addSelect('id', 'name');
                },
                'images' => function ($query) {
                    $query->addSelect('imageable_id', 'image');
                },
                'productReviews' => function ($query) {
                    $query->addSelect('product_id', 'ratings');
                },
                'stockType' => function ($query) {
                    $query->addSelect('id', 'value');
                },
                'mainVariation' => function($query) {
                    $query->addSelect([
                        'id', 'price', 'previous_price', 'is_price_visible', 'currency_id',
                    ]);
                },
                'mainVariation.currency' => function ($query) {
                    $query->addSelect(['id', 'rate']);
                }
            ])
            ->where('status', Status::ACTIVE);
    }
}
