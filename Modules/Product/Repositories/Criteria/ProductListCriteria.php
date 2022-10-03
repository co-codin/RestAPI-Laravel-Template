<?php

namespace Modules\Product\Repositories\Criteria;

use App\Enums\Status;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ProductListCriteria implements CriteriaInterface
{
    //        id
//                name
//                article
//                image
//                slug
//                group_id
//                stockType {
//            value
//                }
//                category {
//            name
//                }
//                brand {
//            name
//                }
//                mainVariation {
//            id
//                    price
//                    previous_price
//                    is_price_visible
//                    currency_id
//                    stock_type
//                    currency {
//                rate
//                    }
//                }
//                images {
//            image
//                }
//                productReviews {
//            ratings {
//                name
//                        rate
//                    }
//                }
//                rating
//                productReviewCount
//                productAnswerCount
//            }


    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select([
                'id', 'name', 'article', 'image', 'slug', 'group_id', 'brand_id', 'stock_type_id'
            ])
            ->withMainVariation()
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
                }
            ])
            ->where('status', Status::ACTIVE);
    }
}
