<?php


namespace App\Http\Builders;


use App\Dto\HttpBuilderRelationDto;
use App\Dto\HttpBuilderRelationDtoCollection;
use Illuminate\Support\Collection as SupportCollection;

abstract class BaseBuilder
{
    protected string $relationName = '';

    /**
     * @var HttpBuilderRelationDtoCollection|HttpBuilderRelationDto[]|null
     */
    protected ?HttpBuilderRelationDtoCollection $relationDto;

    public function __construct(?HttpBuilderRelationDtoCollection $relationDto = null)
    {
        if (!is_null($relationDto)) {
            $this->relationName = $relationDto[0]->relationName;
        }

        $this->relationDto = $relationDto;
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
     * @param array|SupportCollection $fields
     * @return SupportCollection
     * @throws \Exception
     */
    final protected function getFieldsWithRelationName($fields): SupportCollection
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
