<?php


namespace App\Dto;


class HttpBuilderRelationDto extends BaseDto
{
    public string $relationName;
    public string $table;
    public string $first;
    public string $operator = '=';
    public string $second;
    public ?int $limit;
}
