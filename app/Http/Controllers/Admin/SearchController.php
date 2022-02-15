<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Search\PageSearch;
use App\Services\Search\ProductSearch;

class SearchController extends Controller
{
    protected $mappings = [
        [
            'service' => ProductSearch::class,
            'columns' => [
                'name',
            ],
        ],
        [
            'service' => PageSearch::class,
            'columns' => [
                'name',
            ]
        ],
    ];

    public function __invoke()
    {
        foreach ($this->mappings as $mapping) {
            $mapping['service']->seach(request()->get('term'));
        }
    }
}
