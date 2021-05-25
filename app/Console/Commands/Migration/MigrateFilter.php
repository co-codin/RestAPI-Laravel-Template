<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Filter\Models\Filter;

class MigrateFilter extends Command
{
    protected $signature = 'migrate:filter';

    protected $description = 'Migrate filter';

    protected $filters;

    protected $filterCategories;

    public function handle()
    {
        $this->filters = DB::connection('old_medeq_mysql')
            ->table('filters')
            ->get();
        $this->filterCategories = DB::connection('old_medeq_mysql')
            ->table('filter_categories')
            ->get()
            ->groupBy('category_id');

        foreach ($this->filterCategories as $categoryId => $filters) {
            $filterIds = $filters->pluck('filter_id');

            $filters = $this->filters->whereIn('id', $filterIds);

            foreach ($filters as $filter) {
                Filter::query()->insert(array_merge(
                    $this->transform($filter),
                    ['category_id' => $categoryId]
                ));
            }
        }
    }

    protected function transform($item)
    {
        return [
            'name' => $item->title,
            'slug' => $item->slug,
            'type' => $item->type,
            'is_enabled' => $item->status === 1,
            'is_default' => $item->is_default === 1,
            'description' => $item->description,
            'options' => $item->options,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
