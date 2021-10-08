<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Filter\Enums\FilterType;
use Modules\Filter\Models\Filter;
use Modules\Property\Models\Property;

class MigrateFilter extends Command
{
    protected $signature = 'migrate:filter';

    protected $description = 'Migrate filter';

    protected $filters;

    protected function systemFacets()
    {
        return [
            'cena' => [
                'name' => 'price',
                'path' => 'variations',
            ],
            'leaders' => [
                'name' => 'stock_type',
                'value' => 3,
            ],
            'brand' => [
                'name' => 'brand',
            ],
            'specpredlozenia' => [
                'name' => 'is_hot',
                'path' => 'variations',
                'value' => 1,
            ],
            'sostoanie' => [
                'name' => 'condition',
                'path' => 'variations',
            ],
            'vnalicii' => [
                'name' => 'availability',
                'path' => 'variations',
                'value' => 1,
            ],
            'recommed' => [
                'name' => 'stock_type',
                'value' => 4,
            ],
            'made_in_russia' => [
                'name' => 'brand.country',
                'value' => 13,
            ],
            'direction' => [
                'name' => 'root_category',
            ],
        ];
    }

    public function handle()
    {
        $filters = DB::connection('old_medeq_mysql')
            ->table('filters')
            ->get();

        $filterCategories = DB::connection('old_medeq_mysql')
            ->table('filter_categories')
            ->get()
            ->keyBy('filter_id');

        $properties = Property::all()->keyBy('id');

        foreach ($filters as $filter)
        {
            $filterCategory = $filterCategories->get($filter->id);

            if(!$filterCategory) {
                continue;
            }

            $data = $this->transform($filter, $filterCategory);

            $data['property_id'] = \Arr::get(json_decode($filter->options, true) ?? [], 'property_id');

            if($data['property_id'] && !$properties->has($data['property_id'])) {
                continue;
            }

            Filter::query()->create($data);
        }

        $this->createRootCategoryFilter();
    }

    protected function transform(object $filter, object $filterCategory = null): array
    {
        return [
            'id' => $filter->id,
            'name' => $filter->title,
            'category_id' => $filterCategory->category_id,
            'position' => $filterCategory->position,
            'slug' => $filter->slug,
            'type' => $filter->type,
            'is_enabled' => $filter->status == 1,
            'is_default' => $filter->is_default == 1,
            'description' => $filter->description,
            'options' => $filter->options,
            'created_at' => $filter->created_at,
            'updated_at' => $filter->updated_at,
            'facet' => \Arr::get($this->systemFacets(), $filter->slug, null),
        ];
    }

    protected function createRootCategoryFilter()
    {
        Filter::query()->create([
            'name' => 'Направление',
            'category_id' => null,
            'slug' => 'direction',
            'type' => FilterType::CheckMarkList,
            'is_enabled' => true,
            'is_default' => true,
            'facet' => \Arr::get($this->systemFacets(), 'direction', null),
        ]);
    }
}
