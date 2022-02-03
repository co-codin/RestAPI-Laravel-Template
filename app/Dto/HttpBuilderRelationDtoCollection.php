<?php


namespace App\Dto;


class HttpBuilderRelationDtoCollection extends BaseDtoCollection
{
    public function getSingleDtoClass(): string
    {
        return HttpBuilderRelationDto::class;
    }

    public function offsetGet($key): HttpBuilderRelationDto
    {
        return parent::offsetGet($key);
    }
}
