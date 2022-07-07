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
                'id', 'name', 'slug', 'full_description', 'published_at', 'summary', 'note', 'images'
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
                ;
            }])
            ;
    }
}
