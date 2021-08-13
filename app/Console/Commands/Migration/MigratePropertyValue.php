<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigratePropertyValue extends Command
{
    protected $signature = 'migrate:property_value';

    protected $description = 'Migrate property value';

    protected $propertyValues;

    protected $bookItems;

    protected $properties;

    public function handle()
    {
        $this->propertyValues = DB::connection('old_medeq_mysql')->table('property_values')->get();
        $this->bookItems = DB::connection('old_medeq_mysql')->table('book_items')->get();
        $this->properties = DB::connection('old_medeq_mysql')->table('properties')->get();

        foreach ($this->propertyValues as $propertyValue) {
            DB::table('product_property')->insert(
                $this->transform($propertyValue)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'property_id' => $item->property_id,
            'product_id' => $item->product_id,
            'pretty_key' => $item->specification_key,
            'pretty_value' => $item->specification_value,
            'value' => $item->value ? $this->getBookItem($item->value, $item->property_id) : null,
        ];
    }

    protected function getBookItem($value, $property_id)
    {
        $property = $this->properties->where('id', '=', (int) $property_id)->first();

        if ($bookItem = $this->bookItems->where('id', (int) $value)->first()) {
            if ($property->type === 4) {
                return json_encode($bookItem->title);
            }
            else if ($property->type === 2) {
                return json_encode((array) $bookItem);
            }
            else if ($property->type === 1) {
                if ((int)$value === 1) {
                    return json_encode($value);
                } else if ((int)$value === 2) {
                    return json_encode(0);
                }
            }
        }
    }
}
