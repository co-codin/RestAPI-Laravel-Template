<?php

namespace Modules\Category\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategorySaved
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public $category
    ){}
}
