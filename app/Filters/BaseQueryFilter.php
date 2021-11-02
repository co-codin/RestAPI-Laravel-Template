<?php


namespace App\Filters;


abstract class BaseQueryFilter
{
    protected function implode($value): string
    {
        return implode(',', is_array($value) ? $value : [$value]);
    }
}
