<?php

namespace Modules\Search\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Search\Collections\FilteredCollection;

interface IndexableRepository
{
    /**
     * @return LengthAwarePaginator|FilteredCollection|mixed
     */
    public function findByQuery(array $query, array $aggregations = [], int $perPage = 15, ?array $sort = null);

    public function findByTerm(array $query, int $perPage): LengthAwarePaginator;

    public function findForSearch(array $query, int $size = 10): FilteredCollection;

    public function getItemsToIndex();
}
