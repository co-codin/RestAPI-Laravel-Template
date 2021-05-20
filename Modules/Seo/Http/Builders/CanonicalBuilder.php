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
