<?php

namespace App\Console\Commands\Migration;

use App\Console\Commands\Migration\Enums\OldStatus;
use App\Enums\Status;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Vacancy\Models\Vacancy;

class MigrateVacancies extends Command
{
    protected $signature = 'migrate:vacancies';

    protected $description = 'Migrate Vacancies';

    public function handle()
    {
        Model::unguard();

        $oldVacancies = DB::connection('old_medeq_mysql')
            ->table('vacancies')
            ->get();

        foreach ($oldVacancies as $oldVacancy) {
            Vacancy::query()->insert(
                $this->transform($oldVacancy)
            );
        }
    }

    protected function transform($item): array
    {
        $data = [
            'id' => $item->id,
            'name' => $item->title,
            'slug' => $item->slug,
            'short_description' => $item->short_description,
            'full_description' => $item->full_description,
            'status' => $item->status,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        if ($item->status == OldStatus::Deleted) {
            $data = array_merge($data, [
                'deleted_at' => Carbon::now(),
                'status' => Status::INACTIVE,
            ]);
        }

        return $data;
    }
}
