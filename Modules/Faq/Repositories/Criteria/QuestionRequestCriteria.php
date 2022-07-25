<?php


namespace Modules\Faq\Repositories\Criteria;


use App\Http\Filters\LiveFilter;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class QuestionRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(['id', 'question_category_id', 'question', 'status', 'position', 'slug',
                'answer', 'created_at', 'updated_at', 'deleted_at'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('question_category_id'),
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'question' => 'like',
                    'answer' => 'like',
                    'slug' => '=',
                ])),
                AllowedFilter::partial('question'),
                AllowedFilter::partial('answer'),
                AllowedFilter::partial('slug'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('position'),
            ])
            ->allowedSorts('id', 'question_category_id', 'question', 'status', 'position', 'slug',
                'answer', 'created_at', 'updated_at', 'deleted_at')
            ->allowedIncludes('questionCategory')
            ;
    }
}
