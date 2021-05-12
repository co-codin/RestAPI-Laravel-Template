<?php


namespace Modules\Seo\Http\Builders;


use App\Http\Builders\BaseBuilder;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Concerns\SortsQuery;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

class CanonicalBuilder extends BaseBuilder
{
    public function builder(Model|Builder|string $model): SortsQuery|SpatieQueryBuilder
    {
        $query = !is_a($model, Builder::class) ? $model::query() : $model;

        return SpatieQueryBuilder::for($query)
            ->allowedFields(array_merge(
                $this->getFields(),
            ))
            ->defaultSort('-id')
            ->allowedFilters(array_merge(
                $this->getFilters(),
            ));
    }

    /**
     * @param array|null $columns
     * @return string[]
     */
    public function getFields(?array $columns = null): array
    {
        $fields = [
            'id',
            'url',
            'canonical',
        ];

        return $this->filter($fields, $columns)
            ->map($this->fieldWithRelationName())
            ->toArray();
    }

    /**
     * @param array|null $columns
     * @return array
     */
    public function getFilters(?array $columns = null): array
    {
        $filters = [
            'url',
            'canonical',
        ];

        if (!is_null($this->relationDtoCollection)) {
            $filters = [];
        }

        return $this->filter($filters, $columns)->toArray();
    }
}
