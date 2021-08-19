<?php

namespace Modules\Product\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Product\Models\Product;

class ProductSaved
{
    use Dispatchable, SerializesModels;

    public Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
}
