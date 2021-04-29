<?php

namespace Tests\Feature\Modules\Product\Admin\Document;

use Modules\Product\Models\Product;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_authenticated_can_update_document()
    {
        $product = Product::factory()->create();

        
    }
}
