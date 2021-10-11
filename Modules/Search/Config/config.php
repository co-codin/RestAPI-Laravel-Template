<?php

return [
    'name' => 'Search',
    'indices' => [
        Modules\Product\Indices\ProductIndex::class,
        Modules\Brand\Indices\BrandIndex::class,
        Modules\Category\Indices\CategoryIndex::class,
    ],
];
