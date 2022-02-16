<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GlobalSearchRequest;
use App\Services\Search\PageSearch;
use App\Services\Search\ProductSearch;

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
//            'columns' => [
//                'name',
//            ]
//        ],
    ];

    public function __invoke(GlobalSearchRequest $request)
    {
        foreach ($this->mappings as $mapping) {
            $class = $mapping['service'];

            (new $class)->search($request->get("term"), $mapping);

//            $builder = $mapping['service']->seach(
//                $request->get("term"),
//                $mapping
//            );
        }
    }
}
