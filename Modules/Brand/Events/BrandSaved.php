<?php

namespace Modules\Brand\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BrandSaved
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public $brand
    ){}
}
