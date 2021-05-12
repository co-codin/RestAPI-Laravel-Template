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

    public function __construct()
    {
        parent::__construct();
        $this->propertyValues = DB::connection('old_medeq_mysql')->table('property_values')->get();
        $this->bookItems = DB::connection('old_medeq_mysql')->table('book_items')->get();
    }

    public function handle()
    {
        foreach ($this->propertyValues as $propertyValue) {
            DB::table('property_value')->insert(
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
            'value' => $item->value ? $this->getBookItem($item->value) : null,
        ];
    }

    protected function getBookItem($id)
    {
        if (!$bookItem = $this->bookItems->where('id', (int) $id)->first()) {
            return null;
        }
        return json_encode((array) $bookItem);
    }
}
