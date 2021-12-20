<?php

namespace Modules\Cabinet\Services;

use Illuminate\Support\Arr;
use Modules\Cabinet\Models\Cabinet;

class CabinetCategoryStorage
{
    public function update(Cabinet $cabinet, array $categories)
    {
        $cabinet->categories()->sync(
            collect($categories)
                ->keyBy('id')
                ->map(fn($item) => Arr::only($item, [
                    'name',
                    'price',
                    'count',
                    'position',
                ]))
                ->toArray()
        );
    }
}
