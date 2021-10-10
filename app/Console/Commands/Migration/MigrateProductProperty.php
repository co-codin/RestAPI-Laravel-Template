<?php

namespace App\Console\Commands\Migration;

use App\Models\FieldValue;
use Illuminate\Console\Command;
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

    public function handle()
    {
        $this->properties = Property::all()->keyBy('id');
        $this->propertyValues = DB::connection('old_medeq_mysql')->table('property_values')->whereNotNull('value')->get();
        $this->books = DB::connection('old_medeq_mysql')->table('books')->get()->keyBy('id');
        $this->bookItems = DB::connection('old_medeq_mysql')->table('book_items')->get()->keyBy('id');

        foreach ($this->propertyValues as $propertyValue) {

            $property = $this->properties->get($propertyValue->property_id);
            $propertyValue->value = json_decode($propertyValue->value, true);

            if($property === null || $propertyValue->value === null) {
                continue;
            }

            DB::table('product_property')->insert(
                $this->transform($property, $propertyValue)
            );
        }
    }

    /**
     * @throws \JsonException
     */
    protected function transform(Property $property, $propertyValue): array
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

        return [
            'property_id' => $property->id,
            'product_id' => $propertyValue->product_id,
            'pretty_key' => $propertyValue->specification_key,
            'pretty_value' => $propertyValue->specification_value,
            'field_value_ids' => !$property->is_numeric
                ? json_encode($this->transformValue($property, $value), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
                : null,
            'value' => $property->is_numeric ? json_encode($value, JSON_THROW_ON_ERROR) : null
        ];
    }

    protected function transformValue($property, $value)
    {
        return match ($property->type) {
            # mark
            1 => $value == 1 ? : 2,
            # book
            4 => $this->convertToFieldValue($this->getBookItemValue($value)),
            # text input etc
            default => $this->convertToFieldValue($value),
        };
    }

    protected function getBookItemValue($value)
    {
        if(is_array($value)) {
            $items = $this->bookItems->where('id', $value);
            return $items->isNotEmpty()
                ? $items->pluck('title')->toArray()
                : null;
        }

        $item = $this->bookItems->get($value);

        if(!$item) {
            return null;
        }

        return $item->title;
    }

    protected function convertToFieldValue($value)
    {
        if(is_array($value)) {
            $fieldValues = [];
            foreach ($value as $item) {
                $fieldValues[] = FieldValue::query()->firstOrCreate(['value' => $item]);
            }
            return collect($fieldValues)->pluck('id')->toArray();
        }

        return FieldValue::query()->firstOrCreate(['value' => $value])->id;
    }
}
