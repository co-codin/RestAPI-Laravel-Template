<?php


namespace Modules\Case\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CasePageCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->addSelect(
                'id', 'name', 'slug', 'full_description', 'summary', 'note', 'images'
            )
            ->with(['products' => function ($query) {
                $query
                    ->withMainVariation()
                    ->addSelect(
                        'id', 'name', 'article', 'image', 'slug', 'group_id', 'stock_type_id'
                    )->with([
                        'stockType' => function ($query) {
                            $query->addSelect('id', 'value');
                        }
                    ])
                    ->with([
                        'category' => function ($query) {
                            $query->addSelect('id', 'name');
                        }
                    ])
                    ->with([
                        'images' => function ($query) {
                            $query->addSelect('imageable_id', 'image');
                        }
                    ])
                    ->with([
                        'productReviews' => function ($query) {
                            $query->addSelect('product_id', 'ratings');
                        }
                    ])
                    ->withCount('productReviews AS productReviewCount')
                    ->withCount('productAnswers AS productAnswerCount')
                ;
            }])
            ;
    }
}
