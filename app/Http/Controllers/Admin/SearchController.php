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
            'columns' => [
                'name',
            ],
        ],
//        [
//            'service' => PageSearch::class,
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

            dd(
                $builder
            );

            $globalBuilder->union($builder);
        }
    }
}
