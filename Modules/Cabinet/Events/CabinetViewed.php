<?php

namespace Modules\Cabinet\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Cabinet\Models\Cabinet;
use Modules\News\Models\News;

class CabinetViewed
{
    use SerializesModels;

    public $cabinet;

    public function __construct(Cabinet $cabinet)
    {
        $this->cabinet = $cabinet;
    }
}
