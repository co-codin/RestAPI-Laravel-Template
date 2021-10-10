<?php

namespace App\Console\Commands\Migration;

use App\Models\FieldValue;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Property\Models\Property;

class MigrateProductProperty extends Command
{
    protected $signature = 'migrate:product_property';

    protected $description = 'Migrate product properties';

    protected Collection $properties;

    protected Collection $propertyValues;

    protected Collection $books;

    protected Collection $bookItems;

    /**
     * @throws \JsonException
     */
    public function handle()
    {
        $this->properties = Property::all()->keyBy('id');
        $this->propertyValues = DB::connection('old_medeq_mysql')->table('property_values')->whereNotNull('value')->get();
        $this->books = DB::connection('old_medeq_mysql')->table('books')->get()->keyBy('id');
        $this->bookItems = DB::connection('old_medeq_mysql')->table('book_items')->get()->keyBy('id');

        $propertiesCsv = collect([]);
        if (($handle = fopen(storage_path('app/field-values/field_value_ids.csv'), "rb")) !== false) {
            while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                $propertiesCsv->add([
                    'id' => (int)$data[0],
                    'is_numeric' => (bool)((int)$data[1])
                ]);
            }
            rewind($handle);
            fclose($handle);
        }

        foreach ($this->propertyValues as $propertyValue) {
            $property = $this->properties->get($propertyValue->property_id);
            $propertyValue->value = json_decode($propertyValue->value, true, 512, JSON_THROW_ON_ERROR);

            if ($property === null || $propertyValue->value === null) {
                continue;
            }

            $propertyCsv = $propertiesCsv->where('id', $property->id)->first();

            DB::table('product_property')->insert(
                $this->transform($property, $propertyValue, $propertyCsv)
            );
        }
    }

    /**
     * @throws \JsonException
     */
    protected function transform(Property $property, $propertyValue, ?array $propertyCsv = null): array
    {
        $value = $propertyValue->value;

//        if (!$property->is_numeric) {
//            if (is_array($value)) {
//                $arrayValue = [];
//                foreach ($value as $item) {
//                    $fieldValue = FieldValue::query()->firstOrCreate(['value' => $item]);
//                    $arrayValue[] = $fieldValue->value;
//                }
//                $value = $arrayValue;
//            }
//            else {
//                $fieldValue = FieldValue::query()->firstOrCreate(['value' => $value]);
//                $value = $fieldValue->value;
//            }
//        }
        $isNumeric = Arr::get($propertyCsv, 'is_numeric', false);

        return [
            'property_id' => $property->id,
            'product_id' => $propertyValue->product_id,
            'pretty_key' => $propertyValue->specification_key,
            'pretty_value' => $propertyValue->specification_value,
            'field_value_ids' => !is_null($propertyCsv) && !$isNumeric
                ? json_encode($this->transformForFieldValue($property, $value), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
                : null,
            'value' => !is_null($propertyCsv) && $isNumeric ? $this->transformValue($property, $value) : null
        ];
    }

    protected function transformForFieldValue($property, $value)
    {
        return match ($property->type) {
            # mark
            1 => $value == 1 ?: 2,
            # book
            4 => $this->convertToFieldValueFromBookItems($this->getBookItems($value)),
            # text input etc
            default => $this->convertToFieldValue($value),
        };
    }

    /**
     * @throws \JsonException
     */
    protected function transformValue($property, $value)
    {
        # book
        if ($property->type == 4) {
            $bookItems = $this->getBookItems($value);

            $titleArray = count($bookItems) === 1
                ? $bookItems[0]['title']
                : Arr::pluck($this->getBookItems($value), 'title');

            $value = json_encode($titleArray, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        } else {
            $value = json_encode($value, JSON_THROW_ON_ERROR);
        }

        return $value;
    }

    protected function getBookItems($value): ?array
    {
        if (is_array($value)) {
            $items = $this->bookItems->where('id', $value);

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

        if (count($fieldValues) === 1) {
            return $fieldValues[0]['id'];
        }

        return collect($fieldValues)->pluck('id')->toArray();
    }
}
