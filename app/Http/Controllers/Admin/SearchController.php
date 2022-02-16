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
            'columns' => [
                'name', 'full_description', 'short_description',
                'seo.title', 'seo.description', 'seo.h1',
            ],
        ],
        [
            'service' => PageSearch::class,
            'columns' => [
                'name', 'full_description',
                'seo.title', 'seo.description', 'seo.h1',
            ]
        ],
    ];

    public function __invoke(GlobalSearchRequest $request)
    {
        $builders = [];

        foreach ($this->mappings as $mapping) {
            $builder = (new $mapping['service'])->search(
                $request->get("term"),
                $mapping
            );

            $builders[] = $builder;
        }
        

        $count = 0;
        $n1 = $builders[0];
        $n2 = $builders[1];
        $globalBuilder = null;


        while ($count < count($builders)) {
            $globalBuilder = $n2->unionAll($n1);
            $n1 = $n2;
            $n2 = $globalBuilder;

            $count++;
        }

        dd(
            $globalBuilder
        );

//        return $globalBuilder->get();
    }
}
