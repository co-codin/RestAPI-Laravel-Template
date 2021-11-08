<?php


namespace Modules\Seo\Http\Builders;


use App\Http\Builders\BaseBuilder;
use App\Http\Filters\DateFilter;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Concerns\SortsQuery;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

class CanonicalBuilder extends BaseBuilder
{
    public function builder(Model|Builder|string $model): SortsQuery|SpatieQueryBuilder
    {
        return SpatieQueryBuilder::for($this->getQuery($model))
            ->allowedFields($this->getFields())
            ->defaultSort('-id')
            ->allowedFilters($this->getFilters());
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
            'created_at',
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
            'id',
            'url',
            'canonical',
            'created_at' => AllowedFilter::custom('created_at', new DateFilter(), 'created_at'),
            'updated_at' => AllowedFilter::custom('created_at', new DateFilter(), 'updated_at'),
        ];

        if (!is_null($this->relationDtoCollection)) {
            $filters = [];
        }

        return $this->filter($filters, $columns)->toArray();
    }
}
