<?php

namespace Modules\Search\Repositories;

use App\Facades\Elasticsearch;
use Illuminate\Database\Eloquent\Model;
use App\Concerns\Searchable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Modules\Search\Collections\FilteredCollection;

trait IndexableRepositoryTrait
{
    /**
     * @param array $query
     * @param array|null $aggregations
     * @param int $size
     * @param array|null $sort
     * @return LengthAwarePaginator|FilteredCollection
     */
    public function findByQuery(array $query, ?array $aggregations = null, int $size = 15, ?array $sort = null)
    {
        $page = Paginator::resolveCurrentPage("page") - 1;

        $body = [
            'query' => $query,
            'size' => $size,
            'from' => $page * $size,
            '_source' => ['id'],
        ];

        if($aggregations) {
            $body['aggs'] = $aggregations;
        }

        if($sort) {
            $body['sort'] = $sort;
        }

        return $this->withPagination(
            $this->search($body), $size
        );
    }

    /**
     * @param array $query
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function findByTerm(array $query, int $perPage): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage("page") - 1;

        $body = [
            'query' => $query,
            'size' => $perPage,
            'from' => $page * $perPage,
        ];

        return $this->withPagination($this->search($body), $perPage);
    }

    /**
     * @param array $query
     * @param int $size
     * @return FilteredCollection
     */
    public function findForSearch(array $query, int $size = 10): FilteredCollection
    {
        $body = [
            'query' => $query,
            'size' => $size,
        ];

        return $this->buildCollection($this->search($body));
    }

    protected function search(array $body): array
    {
        $class = $this->model();

        /** @var Searchable|Model $model */
        $model = new $class;

        return ElasticSearch::search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => $body,
        ]);
    }

    protected function buildCollection(array $result) : FilteredCollection
    {
        $ids = Arr::pluck($result['hits']['hits'], '_id');

        $products = $this
            ->findWhereIn('id', $ids)
            ->sortBy(function ($product) use ($ids) {
                return array_search($product->getKey(), $ids);
            })
            ->values();

        return new FilteredCollection($products, $result);
    }

    /**
     * @param array $result
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    protected function withPagination(array $result, int $perPage = 15)
    {
        $total = Arr::get($result, 'hits.total.value');

        $collection = $this->buildCollection($result);

        $paginator = new LengthAwarePaginator($collection, $total, $perPage);

        return $paginator
            ->withPath(Paginator::resolveCurrentPath());
    }
}
