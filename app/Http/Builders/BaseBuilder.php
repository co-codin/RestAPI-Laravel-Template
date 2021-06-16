<?php


namespace App\Http\Builders;


use App\Dto\HttpBuilderRelationDto;
use App\Dto\HttpBuilderRelationDtoCollection;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection as SupportCollection;

abstract class BaseBuilder
{
    protected string $relationName = '';

    /**
     * BaseBuilder constructor.
     * @param HttpBuilderRelationDtoCollection|HttpBuilderRelationDto[]|null $relationDtoCollection
     */
    public function __construct(
        protected ?HttpBuilderRelationDtoCollection $relationDtoCollection = null
    )
    {
        if (!is_null($relationDtoCollection)) {
            $this->relationName = $relationDtoCollection[0]->relationName;
        }
    }

    final protected function getQuery(Model|EloquentBuilder|Relation|string $model): EloquentBuilder|Relation|string
    {
        return is_a($model, Model::class) ? $model::query() : $model;
    }

    /**
     * @param array $allFields
     * @param array|null $columns
     * @return SupportCollection
     */
    final protected function filter(array $allFields, ?array $columns = null): SupportCollection
    {
        return collect($allFields)
            ->filter(function ($item, $key) use ($columns) {
                return !empty($columns[$key]) || !empty($columns[$item]) || is_null($columns);
            })
            ->values();
    }

    /**
     * @return \Closure
     */
    final protected function fieldWithRelationName(): \Closure
    {
        return fn(string $field) => !empty($this->relationName) ? $this->relationName . '.' . $field : $field;
    }

    /**
     * @param SupportCollection|array $fields
     * @return SupportCollection
     * @throws \Exception
     */
    final protected function getFieldsWithRelationName(SupportCollection|array $fields): SupportCollection
    {
        if (!$fields instanceof SupportCollection || !is_array($fields)) {
            throw new \Exception('
                The fields parameter must be of type array or '
                . SupportCollection::class . ' given ' . gettype($fields)
            );
        }

        $fields = is_array($fields) ? collect($fields) : $fields;

        return $fields->map(
            fn(string $field) => !is_null($this->relationName) ? $this->relationName . '.' . $field : $field
        );
    }
}
