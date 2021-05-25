<?php


namespace App\Concerns;


trait Searchable
{
    protected function searchIndex()
    {
        return $this->getTable();
    }

    protected function searchType()
    {
        return '_doc';
    }

    public function getSearchIndex()
    {
        return config('elasticsearch.index_prefix') . $this->searchIndex();
    }

    public function getSearchType()
    {
        return $this->searchType();
    }

    public function toSearchArray()
    {
        return $this->toArray();
    }
}
