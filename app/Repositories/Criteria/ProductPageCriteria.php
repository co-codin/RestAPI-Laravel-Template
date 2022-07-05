<?php

namespace App\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ProductPageCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select([
                'id', 'name', 'article', 'booklet', 'short_description',
                'full_description', 'image', 'has_test_drive', 'group_id',
                'documents',  'brand_id', 'stock_type_id', 'country_id',
                'slug', 'video', 'status', 'warranty', 'warranty_info',
                'is_arbitrary_warranty', 'arbitrary_warranty_info',
            ])
            ->with('seo')
            ->with([
                'brand' => function ($query) {
                    $query->addSelect('id', 'name');
                }])
            ->with([
                'stockType' => function ($query) {
                    $query->addSelect('id', 'value');
                }
            ])
            ->with([
                'country' => function ($query) {
                    $query->addSelect('id', 'value');
                }
            ])
            ->with([
                'images' => function ($query) {
                    $query->addSelect('imageable_id', 'image', 'caption');
                }
            ])
            ->with([
                'properties' => function ($query) {
                    $query->addSelect();
                }
            ])


//            ->with([
//                'category' => function ($query) {
//                    $query->addSelect('id', 'name');
//                }
//            ])
//            ->with([
//                'productReviews' => function ($query) {
//                    $query->addSelect('product_id', 'ratings');
//                }
//            ])
//

            ->withCount('productReviews AS productReviewCount')
            ->withCount('productQuestions AS productQuestionCount')
            ->withCount('productAnswers AS productAnswerCount')

            ;
    }
}
