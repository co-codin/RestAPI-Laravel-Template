<?php

namespace Modules\Export\Console;

use Illuminate\Console\Command;

class GenerateYandexMarket extends Command
{
    protected $signature = 'generate:yandex-market {parameters}';

    protected $description = 'generate xml for yandex market';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $parameters = $this->argument('parameters');
    }
}
