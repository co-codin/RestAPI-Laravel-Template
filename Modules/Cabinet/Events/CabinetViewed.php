<?php

namespace Modules\Cabinet\Events;

use Illuminate\Queue\SerializesModels;

class CabinetViewed
{
    use SerializesModels;

    public $cabinet;

    public function __construct($cabinet)
    {
        $this->cabinet = $cabinet;
    }
}
