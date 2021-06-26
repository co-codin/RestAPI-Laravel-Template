<?php

namespace Modules\Export\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Models\Export;
use Modules\Export\Repositories\ExportRepository;
use Modules\Export\Services\ExportService;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /*$this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            foreach (Export::query()->get() as $export) {
                $command = (new ExportService)->determine($export);

                $frequency = ExportFrequency::getFrequency($export->frequency);

                if ($frequency !== ExportFrequency::MANUALLY) {
                    $schedule = $schedule->command($command, array_merge($export->parameters, [
                        'filename' => $export->filename,
                    ]))
                        ->$frequency();
                }
            }
        });*/
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
