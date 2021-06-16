<?php

namespace Modules\Export\Console;

use Illuminate\Console\Command;

class GenerateYandexMarket extends Command
{
    protected $signature = 'generate:yandex-market';

    protected $description = 'generate xml for yandex market';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //
    }
}
