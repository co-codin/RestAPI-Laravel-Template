<?php

namespace App\Console\Commands\Migration;

use App\Console\Commands\Migration\Enums\OldPropertyType;
use App\Models\FieldValue;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Filter\Enums\FilterType;
use Modules\Filter\Models\Filter;
use function Clue\StreamFilter\fun;

class MigrateFilter extends Command
{
    protected $signature = 'migrate:filter';

    protected $description = 'Migrate filter';

    protected $filters;

    protected function systemFacets()
    {
        return [
            'cena' => [
                'name' => 'price_in_rub',
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
        Model::unguard();

        $filters = DB::connection('old_medeq_mysql')
            ->table('filters')
            ->get();

        $filterCategories = DB::connection('old_medeq_mysql')
            ->table('filter_categories')
            ->get()
            ->keyBy('filter_id');

        $properties = DB::connection('old_medeq_mysql')
            ->table('properties')
            ->select(['id', 'type'])
            ->get();

        $filters = $filters
            ->map(function (object $filter) use ($properties): object {
                $options = json_decode($filter->options, JSON_THROW_ON_ERROR, 512, JSON_THROW_ON_ERROR);

                $property = $properties
                    ->where('id', \Arr::get($options, 'property_id'))
                    ->first();

                $filter->options = array_merge(
                    $options,
                    ['property_type' => $property?->type]
                );

                return $filter;
            });

//        $bookSeoTagLabelsKeys = $filters
//            ->where('type', OldFilterType::CheckMarkList)
//            ->where('options.property_type', OldPropertyType::Book)
//            ->pluck('options.seoTagLabels.*.key');
//
//        $bookItems = DB::connection('old_medeq_mysql')
//            ->table('book_items')
//            ->select(['id', 'title', 'slug'])
//            ->whereIn('slug', $bookSeoTagLabelsKeys->toArray())
//            ->get();
//
//        $fieldValueIds = FieldValue::query()
//            ->select(['id', 'value'])
//            ->whereIn('value', $bookItems->pluck('title')->toArray())
//            ->get();
//        dd($fieldValueIds->count());

        $propertiesKeyById = $properties->keyBy('id');

        foreach ($filters as $filter)
        {
            $filterCategory = $filterCategories->get($filter->id);

            if (!$filterCategory) {
                continue;
            }

            $propertyId = \Arr::get($filter->options ?? [], 'property_id');

            if ($propertyId && !$propertiesKeyById->has($propertyId)) {
                continue;
            }

            $data = $this->transform($filter, $filterCategory);
            $data['property_id'] = $propertyId;

            Filter::query()->create($data);
        }

        $this->createRootCategoryFilter();
        $this->updateDefaultFilterPositions();
    }

    protected function transform(object $filter, object $filterCategory = null): array
    {
        $newOptions = $this->clearOptions($this->getNewOptions($filter->options));
        $facet = \Arr::get($this->systemFacets(), $filter->slug, null);

        if($filter->type == FilterType::CheckMark && !($facet['value'] ?? null)) {
            if(!$facet) $facet = [];
            $facet['value'] = \Arr::pull($newOptions, 'filter_value', 1);
        }

        if($filter->slug == "sostoanie") {
            $newOptions['seoTagLabels'] = $this->prepareConditionFieldLabels($newOptions['seoTagLabels']);
        }

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
            'options' => !empty($newOptions) ? $newOptions : null,
            'created_at' => $filter->created_at,
            'updated_at' => $filter->updated_at,
            'facet' => $facet,
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

    protected function updateDefaultFilterPositions()
    {
        $positions = [
            'Направление',
            'Цена',
            'Производитель',
            'По акции',
            'Лидер продаж',
            'Медэк рекомендует',
            'Произведено в России',
            'Состояние',
            'В наличии',
        ];

        Filter::query()
            ->where('is_default', true)
            ->get()
            ->each(function(Filter $filter) use ($positions) {
                $filter->position = array_search($filter->name, $positions) + 1;
                $filter->save();
            });
    }

    private function getNewOptions(array $options): array
    {
        return match ($options['property_type']) {
            OldPropertyType::Book => $this->bookProperty($options),
            OldPropertyType::TextInput => $this->textProperty($options),
            default => $options,
        };
    }

    private function bookProperty(array $options): array
    {
        if (empty($seoTagLabels = \Arr::get($options, 'seoTagLabels'))) {
            return $options;
        }

        $seoTagLabels = collect($seoTagLabels)
            ->filter(fn(array $seoTagLabel): bool => !is_null($seoTagLabel['key']));

        $bookItems = DB::connection('old_medeq_mysql')
            ->table('book_items')
            ->select(['id', 'title', 'slug'])
            ->whereIn('slug', $seoTagLabels->pluck('key'))
            ->get();

        $fieldValues = FieldValue::query()
            ->select(['id', 'value', 'slug'])
            ->whereIn('value', $bookItems->pluck('title')->toArray())
            ->get();

        $keysWithId = $fieldValues->map(function (FieldValue $fieldValue) use ($bookItems): array {
            $bookItemSlug = $bookItems->where('title', $fieldValue->value)->first()?->slug;

            return [
                'id' => $fieldValue->id,
                'key' => $bookItemSlug
            ];
        });

        $options['seoTagLabels'] = $seoTagLabels->map(function(array $seoTagLabel) use ($keysWithId): array {
            $keyWithId = $keysWithId
                ->where('key', $seoTagLabel['key'])
                ->first();

            $seoTagLabel['key'] = \Arr::get($keyWithId, 'id');

            return $seoTagLabel;
        })
            ->filter(fn(array $seoTagLabel): bool => !is_null($seoTagLabel['key']))
            ->toArray();

        return $options;
    }

    private function textProperty(array $options): array
    {
        if (empty($seoTagLabels = \Arr::get($options, 'seoTagLabels'))) {
            return $options;
        }

        $seoTagLabels = collect($seoTagLabels)
            ->filter(fn(array $seoTagLabel): bool => !is_null($seoTagLabel['key']));

        $fieldValues = FieldValue::query()
            ->select(['id', 'slug'])
            ->whereIn('slug', $seoTagLabels->pluck('key'))
            ->get();

        $options['seoTagLabels'] = $seoTagLabels->map(function(array $seoTagLabel) use ($fieldValues): array {
            $seoTagLabel['key'] = $fieldValues
                ->where('slug', $seoTagLabel['key'])
                ->first()?->id;

            return $seoTagLabel;
        })
            ->filter(fn(array $seoTagLabel): bool => !is_null($seoTagLabel['key']))
            ->toArray();

        return $options;
    }

    private function clearOptions(array $options): array
    {
        $allowedOptions = array_flip(['seoTagLabels', 'seoTagLabel', 'seoPrefix', 'filter_value']);

        return collect($options)
            ->filter(fn(mixed $value, string $name): bool => !empty($value) && array_key_exists($name, $allowedOptions))
            ->toArray();
    }

    protected function prepareConditionFieldLabels(mixed $seoTagLabels)
    {
        $lookupTable = [
            'novyi' => 'Новый',
            'vosstanovlennyi' => 'Восстановленный',
            'demo' => 'Демонстрационный',
            'bu' => 'БУ',
        ];

        return array_map(function($tag) use ($lookupTable) {
            $tag['key'] = FieldValue::query()->firstOrCreate(['value' => $lookupTable[$tag['key']]])->id;
            return $tag;
        }, $seoTagLabels);
    }
}
