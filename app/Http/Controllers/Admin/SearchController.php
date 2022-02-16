<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GlobalSearchRequest;
use App\Services\Search\PageSearch;
use App\Services\Search\ProductSearch;
use Illuminate\Database\Query\Builder;

class SearchController extends Controller
{
    protected $mappings = [
        [
            'service' => ProductSearch::class,
            'is_first' => true,
            'columns' => [
                'name',
            ],
        ],
//        [
//            'service' => PageSearch::class,
//            'is_first' => false,
//            'columns' => [
//                'name',
//            ]
//        ],
    ];

    public function __invoke(GlobalSearchRequest $request)
    {
        $globalBuilder = new Builder();

        foreach ($this->mappings as $mapping) {
            $builder = (new $mapping['service'])->search(
                $request->get("term"),
                $mapping
            );

            $globalBuilder->union($builder);
        }
    }
}
