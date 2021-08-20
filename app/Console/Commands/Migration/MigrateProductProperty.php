<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateProductProperty extends Command
{
    protected $signature = 'migrate:product_property';

    protected $description = 'Migrate product properties';

    protected $propertyValues;

    protected $bookItems;

    protected $properties;

    public function handle()
    {
        $this->propertyValues = DB::connection('old_medeq_mysql')->table('property_values')->get();
        $this->bookItems = DB::connection('old_medeq_mysql')->table('book_items')->get()->keyBy('id');
        $this->properties = DB::connection('old_medeq_mysql')->table('properties')->get()->keyBy('id');

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

    protected function transform($property, $propertyValue)
    {
        return [
            'property_id' => $property->id,
            'product_id' => $propertyValue->product_id,
            'pretty_key' => $propertyValue->specification_key,
            'pretty_value' => $propertyValue->specification_value,
            'value' => json_encode($this->transformValue($property, $propertyValue->value), JSON_UNESCAPED_UNICODE),
        ];
    }

    protected function transformValue($property, $value)
    {
        return match ($property->type) {
            # mark
            1 => $value == 1,
            # book
            4 => $this->getBookItemValue($value),
            # text input etc
            default => $value,
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
}
