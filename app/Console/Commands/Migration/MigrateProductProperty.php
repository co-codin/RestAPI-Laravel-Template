<?php

namespace App\Console\Commands\Migration;

use App\Models\FieldValue;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Property\Models\Property;

class MigrateProductProperty extends Command
{
    protected $signature = 'migrate:product_property';

    protected $description = 'Migrate product properties';

    protected Collection $properties;

    protected Collection $oldProperties;

    protected Collection $propertyValues;

    protected Collection $books;

    protected Collection $bookItems;

    /**
     * @throws \JsonException
     */
    public function handle()
    {
        Model::unguard();

        $this->updateNumericProperties();

        $this->oldProperties = DB::connection('old_medeq_mysql')->table('properties')->pluck('type','id');
        $this->properties = DB::table('properties')->get()->keyBy('id');
        $this->propertyValues = DB::connection('old_medeq_mysql')->table('property_values')->whereNotNull('value')->get();
        $this->books = DB::connection('old_medeq_mysql')->table('books')->get()->keyBy('id');
        $this->bookItems = DB::connection('old_medeq_mysql')->table('book_items')->get()->keyBy('id');

        foreach ($this->propertyValues as $propertyValue) {
            $property = $this->properties->get($propertyValue->property_id);
            $propertyValue->value = json_decode($propertyValue->value, true, 512, JSON_THROW_ON_ERROR);

            if ($property === null || $propertyValue->value === null) {
                continue;
            }

            $property->type = $this->oldProperties->get($property->id);

            $transformedValue = $this->transform($property, $propertyValue);

            if($transformedValue['field_value_ids'] === null) {
                continue;
            }

            DB::table('product_property')->insert(
                $transformedValue
            );
        }
    }

    /**
     * @throws \JsonException
     */
    protected function transform(object $property, $propertyValue): array
    {
        $value = $propertyValue->value;
        $fieldValueIds = $this->transformForFieldValue($property, $value);

        return [
            'property_id' => $property->id,
            'product_id' => $propertyValue->product_id,
            'pretty_key' => $propertyValue->specification_key,
            'pretty_value' => $propertyValue->specification_value,
//            'field_value_ids' => !$property->is_numeric
//                ? json_encode($this->transformForFieldValue($property, $value), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
//                : null,
//            'value' => $property->is_numeric ? $this->transformValue($property, $value) : null
            'field_value_ids' => !is_null($fieldValueIds) ? json_encode($fieldValueIds, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE) : null,
//            'value' => $property->is_numeric ? $this->transformValue($property, $value) : null
        ];
    }

    protected function transformForFieldValue(object $property, $value)
    {
        switch ($property->type) {
            # mark
            case 1:
                return $value == 1 ? 1 : 2;
            # book
            case 4: {
                $bookItems = $this->getBookItems($value);
                return !is_null($bookItems) ? $this->convertToFieldValueFromBookItems($bookItems) : null;
            }
            # text input etc
            default: return $this->convertToFieldValue($value);
        }
    }

    /**
     * @throws \JsonException
     */
    protected function transformValue(object $property, $value)
    {
        # book
        if ($property->type == 4) {

            $bookItems = $this->getBookItems($value);

            if (is_null($bookItems)) {
                return null;
            }

            $value = count($bookItems) === 1
                ? $bookItems[0]['title']
                : Arr::pluck($bookItems, 'title');
        }

        return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }

    protected function getBookItems($value): ?array
    {
        if (is_array($value)) {
            $items = $this->bookItems->whereIn('id', $value)->values();

            return $items->isNotEmpty()
                ? $items->map(fn($item) => Arr::only((array)$item, ['title', 'slug']))->toArray()
                : null;
        }

        $item = $this->bookItems->get($value);

        if (!$item) {
            return null;
        }

        return [
            Arr::only((array)$item, ['title', 'slug'])
        ];
    }

    protected function convertToFieldValue($value)
    {
        if (is_array($value)) {
            $fieldValues = [];

            foreach ($value as $item) {
                $fieldValues[] = FieldValue::query()->firstOrCreate(['value' => $item]);
            }

            return collect($fieldValues)->pluck('id')->toArray();
        }

        return FieldValue::query()->firstOrCreate(['value' => $value])->id;
    }

    /**
     * @param array[] $bookItems
     */
    protected function convertToFieldValueFromBookItems(array $bookItems): int|array
    {
        $fieldValues = [];

        foreach ($bookItems as $item) {
            $fieldValue = FieldValue::query()
                ->select('id')
                ->where('value', $item['title'])
                ->first();

            if (is_null($fieldValue)) {
                $fieldValue = FieldValue::query()->create([
                    'slug' => $item['slug'],
                    'value' => $item['title'],
                ]);
            }

            $fieldValues[] = $fieldValue;
        }

//        if (count($fieldValues) === 1) {
//            return $fieldValues[0]['id'];
//        }

        return collect($fieldValues)->pluck('id')->toArray();
    }

    protected function updateNumericProperties()
    {
        if (!\Storage::exists('app/field-values/field_value_ids.csv')) {
            return;
        }

        if (($handle = fopen(storage_path('app/field-values/field_value_ids.csv'), "rb")) !== false) {
            while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                $id = (int)$data[0];
                $isNumeric = (int)$data[1];
                Property::find($id)?->update(['is_numeric' => $isNumeric]);
            }
            rewind($handle);
            fclose($handle);
        }
    }
}
