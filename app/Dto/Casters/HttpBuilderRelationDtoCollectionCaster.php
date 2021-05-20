<?php


namespace App\Dto\Casters;


use App\Dto\HttpBuilderRelationDto;
use App\Dto\HttpBuilderRelationDtoCollection;
use Spatie\DataTransferObject\Caster;

class HttpBuilderRelationDtoCollectionCaster implements Caster
{
    public function cast(mixed $value): HttpBuilderRelationDtoCollection
    {
        return new HttpBuilderRelationDtoCollection(array_map(
            fn (array $data): HttpBuilderRelationDto => $data instanceof HttpBuilderRelationDto
                ? $data
                : new HttpBuilderRelationDto(...$data),
            $value
        ));
    }
}
