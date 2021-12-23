<?php

namespace Modules\Cabinet\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Cabinet\Models\Cabinet;

class CabinetViewed
{
    use SerializesModels;

    public $cabinet;

    public function __construct(?Cabinet $cabinet)
    {
        $this->cabinet = $cabinet;
    }
}
