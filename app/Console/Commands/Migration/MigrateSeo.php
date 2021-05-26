<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Seo\Models\Seo;

class MigrateSeo extends Command
{
    protected $signature = 'migrate:seo';

    protected $description = 'Migrate seo';

    public function handle()
    {
        $oldSeos = DB::connection('old_medeq_mysql')
            ->table('seo')
            ->get();

        foreach ($oldSeos as $oldSeo) {
            Seo::query()->insert(
                $this->transform($oldSeo)
            );
        }
    }

    protected function transform($item)
    {
        dd(
            $item
        );
        return [
            'id' => $item->id,
            'seoable_type' => '',
        ];
    }
}
