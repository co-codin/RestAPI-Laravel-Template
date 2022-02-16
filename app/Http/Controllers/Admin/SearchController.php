<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GlobalSearchRequest;
use App\Services\Search\BrandSearch;
use App\Services\Search\CategorySearch;
use App\Services\Search\NewsSearch;
use App\Services\Search\PageSearch;
use App\Services\Search\ProductSearch;
use App\Services\Search\SeoRuleSearch;

class SearchController extends Controller
{
    protected array $mappings = [
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
        [
            'service' => BrandSearch::class,
            'columns' => [
                'name', 'full_description',
                'seo.title', 'seo.description', 'seo.h1',
            ],
        ],
        [
            'service' => NewsSearch::class,
            'columns' => [
                'name', 'full_description',
                'seo.title', 'seo.description', 'seo.h1',
            ],
        ],
        [
            'service' => CategorySearch::class,
            'columns' => [
                'name', 'full_description',
                'seo.title', 'seo.description', 'seo.h1',
            ],
        ],
        [
            'service' => SeoRuleSearch::class,
            'columns' => [
                'name', 'text',
                'seo.title', 'seo.description', 'seo.h1',
            ],
        ],
    ];

    public function __invoke(GlobalSearchRequest $request)
    {
        $data = collect();

        foreach ($this->mappings as $mapping) {
            $item = (new $mapping['service'])->search(
                $request->get("term"),
                $mapping
            );
            $data->add($item);
        }

        return $data->flatten()->groupBy('type_ru');
    }
}
