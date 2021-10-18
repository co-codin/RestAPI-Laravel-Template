<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MigrateCharacteristics extends Command
{
    protected $signature = 'migrate:characteristics';

    protected $description = 'Migrate characteristics';

    public function handle()
    {
        Model::unguard();

        $csvData = file_get_contents(storage_path('app/migrate/properties.csv'));
        $lines = explode(PHP_EOL, $csvData);
        array_shift($lines);
        $last = array_key_last($lines);

        foreach ($lines as $key => $line) {
            $data = str_getcsv($line, ';');

            if ($key === $last) {
                continue;
            }
            $categoryName = $data[0];
            $propertyId = (int)$data[1];

            $productIds = DB::table('product_category as pc')
                ->select('pc.product_id')
                ->join('categories as cat', 'cat.id', '=', 'pc.category_id')
                ->where('cat.name', $categoryName)
                ->where('pc.is_main', 1)
                ->get();

            if ($productIds->isEmpty()) {
                continue;
            }

            DB::table('product_property')
                ->select(['property_id', 'product_id', 'is_important'])
                ->where('property_id', $propertyId)
                ->whereIn('product_id', $productIds->pluck('product_id')->toArray())
                ->update(['is_important' => 1]);
        }
    }
}
