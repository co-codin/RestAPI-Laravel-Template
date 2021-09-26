<?php


namespace Modules\Search\Contracts;


interface Filter
{
    public function toFilter() : array;
}
