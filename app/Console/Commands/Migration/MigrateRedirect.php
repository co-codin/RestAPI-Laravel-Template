<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Redirect\Models\Redirect;

class MigrateRedirect extends Command
{
    protected $signature = 'migrate:redirect';

    protected $description = 'Migrate redirect';

    public function handle()
    {
        Model::unguard();

        $oldRedirects = DB::connection('old_medeq_mysql')
            ->table('redirects')
            ->get();

        foreach ($oldRedirects as $oldRedirect) {
            Redirect::query()->insert(
                $this->transform($oldRedirect)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'id' => $item->id,
            'source' => $item->old_url,
            'destination' => $item->new_url,
            'code' => $item->code,
            'assigned_by_id' => 1,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
