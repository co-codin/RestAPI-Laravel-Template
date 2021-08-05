<?php

namespace Modules\Geo\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DLIntegrationCommand extends Command
{
    protected $signature = 'dl:integrate';

    protected $description = 'Интеграция с деловой линии.';

    protected $places;

    protected $terminals;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        dd(
            'working'
        );
    }
}
