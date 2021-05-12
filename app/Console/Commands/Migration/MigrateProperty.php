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
        $oldProperties = DB::connection('old_medeq_mysql')
            ->table('properties')
            ->get();

        foreach ($oldProperties as $oldProperty) {
            Property::query()->insert(
                $this->transform($oldProperty)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->title,
            'type' => $item->type,
            'options' => $item->options,
            'description' => $item->description,
            'is_hidden_from_product' => $item->hide_from_product,
            'is_hidden_from_comparison' => $item->hide_from_comparison,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
