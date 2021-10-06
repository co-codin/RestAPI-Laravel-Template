<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Property\Models\Property;

class MigrateProperty extends Command
{
    protected $signature = 'migrate:property';

    protected $description = 'Migrate property';

    public function handle()
    {
        $filters = DB::connection('old_medeq_mysql')->table('filters')->where('slug', '!=', 'cena')
            ->where('type', 2)
            ->get();

        $numericProperties = $filters
            ->map(fn($filter) => (int) json_decode($filter->options, true)['property_id'])
            ->unique();

        $oldProperties = DB::connection('old_medeq_mysql')
            ->table('properties')
            ->get();

        foreach ($oldProperties as $oldProperty) {
            Property::query()->create(
                $this->transform($oldProperty, $numericProperties->contains($oldProperty->id))
            );
        }
    }

    protected function transform($item, $is_numeric = false)
    {
        return [
            'id' => $item->id,
            'name' => $item->title,
            'options' => $item->options,
            'description' => $item->description,
            'is_numeric' => $is_numeric,
            'is_hidden_from_product' => $item->hide_from_product,
            'is_hidden_from_comparison' => $item->hide_from_comparison,
            'assigned_by_id' => 1,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
