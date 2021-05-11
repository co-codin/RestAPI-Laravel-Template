<?php


namespace App\Dto;


class HttpBuilderRelationDtoCollection extends DtoCollection
{
    public function current(): HttpBuilderRelationDto
    {
        return parent::current();
    }

    public static function create(array $data): HttpBuilderRelationDtoCollection
    {
        $collection = [];

        foreach ($data as $item) {
            $collection[] = HttpBuilderRelationDto::create($item);
        }

        return new self($collection);
    }
}
