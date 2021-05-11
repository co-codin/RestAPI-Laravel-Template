<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Achievement\Models\Achievement;

class MigrateAchievement extends Command
{
    protected $signature = 'migrate:achievement';

    protected $description = 'Migrate achievement';

    public function handle()
    {
        $oldBrands = DB::connection('old_medeq_mysql')
            ->table('achievements')
            ->get();

        foreach ($oldBrands as $oldBrand) {
            Achievement::query()->insert(
                $this->transform($oldBrand)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->title,
            'image' => $item->image,
            'is_enabled' => $item->status === 1,
            'position' => $item->position,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
