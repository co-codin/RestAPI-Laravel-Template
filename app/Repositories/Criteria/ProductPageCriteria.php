<?php

namespace App\Repositories\Criteria;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ProductPageCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select([
                'id',
                'name', 'article', 'booklet', 'short_description', 'stock_type_id',
                'full_description', 'image', 'has_test_drive', 'group_id',
                'documents',  'brand_id', 'country_id',
                'slug', 'video', 'status', 'warranty', 'warranty_info',
                'is_arbitrary_warranty', 'arbitrary_warranty_info', 'benefits',
            ])
            ->with('seo')
            ->with([
                'brand' => function ($query) {
                    $query->addSelect('id', 'name', 'image', 'status');
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
                    $query->addSelect('name', 'description');
                }
            ])
            ->with([
                'category' => function ($query) {
                    $query
                        ->addSelect('id', 'name', 'slug', 'review_ratings')
                        ->with('seoCategoryProducts')
                        ->with([
                            'ancestors' => function ($query) {
                                $query->addSelect('id', 'name', 'slug', '_lft');
                            }
                        ])
                        ;
                }
            ])
            ->with([
                'productReviews' => function ($query) {
                    $query
                        ->addSelect(
                            'id', 'ratings', 'experience', 'advantages', 'comment',
                            'disadvantages', 'first_name', 'last_name', 'is_confirmed',
                            'like', 'dislike', 'created_at', 'client_id'
                        )
                        ->with([
                            'client' => function ($query) {
                                $query->addSelect('first_name', 'last_name', 'avatar');
                            }
                        ])
                        ;
                }
            ])
            ->with([
                'productQuestions' => function ($query) {
                    $query
                        ->addSelect(
                            'id', 'text', 'date', 'first_name', 'last_name',
                        )
                        ->with([
                            'productAnswers' => function ($query) {
                                $query->addSelect(
                                    'id', 'text', 'first_name', 'last_name',
                                    'person', 'like', 'dislike', 'date'
                                );
                            }
                        ])
                        ->with([
                            'client' => function ($query) {
                                $query->addSelect('first_name', 'last_name', 'avatar');
                            }
                        ])
                        ;
                }
            ])
            ->with([
                'productVariations' => function ($query) {
                    $query
                        ->addSelect(
                            'id', 'name', 'price', 'previous_price', 'is_price_visible',
                            'currency_id'
                        )
                        ->with([
                            'currency' => function ($query) {
                                $query->addSelect('id', 'rate');
                            }
                        ])
                    ;
                }
            ])
            ->withCount('productReviews AS productReviewCount')
            ->withCount('productQuestions AS productQuestionCount')
            ->withCount('productAnswers AS productAnswerCount')
            ;
    }
}
