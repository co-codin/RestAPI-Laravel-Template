<?php

namespace Modules\Cabinet\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Cabinet\Models\Cabinet;
use Modules\Category\Models\Category;

class CabinetCategoryStorage
{
    public function update(Cabinet $cabinet, array $categories)
    {
        $categories = collect($categories);

        DB::beginTransaction();

        $ids = $categories->pluck('id')->filter()->unique();

        $cabinet->categories()
            ->when($ids->isNotEmpty(), fn($query) => $query->whereNotIn('id', $ids))
            ->delete();

        $newCategories = $categories->filter(fn($item) => !Arr::exists($item, 'id'));

        $cabinet->categories()->createMany($newCategories);

        $categories
            ->filter(fn($category) => Arr::exists($category, 'id'))
            ->each(function($category) {
                $model = Category::find($category['id']);
                if($model) {
                    $model->update($category);
                }
            });

        DB::commit();
    }
}
