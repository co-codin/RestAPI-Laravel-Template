<?php

namespace Modules\Product\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Product\Models\Product;

class ProductSaved
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public $product
    ){}
}
