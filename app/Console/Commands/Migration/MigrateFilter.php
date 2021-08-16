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

    protected $properties;

    protected $propertyId;

    public function handle()
    {
        $this->filters = DB::connection('old_medeq_mysql')
            ->table('filters')
            ->get();
        $this->properties = DB::connection('old_medeq_mysql')
            ->table('properties')
            ->get();
        $this->filterCategories = DB::connection('old_medeq_mysql')
            ->table('filter_categories')
            ->get()
            ->groupBy('category_id');

        foreach ($this->filterCategories as $categoryId => $filters) {
            $filters = $this->filters->whereIn('id', $filters->pluck('filter_id'));

            foreach ($filters as $filter) {
                if (array_key_exists('property_id', json_decode($filter->options, true))) {
                    $this->propertyId = json_decode($filter->options, true)['property_id'];
                    if ($this->propertyId && $this->properties->where('id', $this->propertyId)->first()) {
                        Filter::query()->insert(array_merge(
                            $this->transform($filter),
                            ['category_id' => $categoryId],
                            ['property_id' => $this->propertyId]
                        ));
                        $this->propertyId = (int)$this->propertyId;
                    } else {
                        Filter::query()->insert(array_merge(
                            $this->transform($filter),
                            ['category_id' => $categoryId]
                        ));
                    }
                }
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
//            'property_id' => array_key_exists('property_id', json_decode($item->options, true)) ? json_decode($item->options, true)['property_id'] : null,
            'options' => $item->options,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
