<?php

namespace Tests\Feature\Modules\Product\Admin\Document;

use Illuminate\Http\UploadedFile;
use Modules\Product\Enums\DocumentSource;
use Modules\Product\Enums\DocumentType;
use Modules\Product\Models\Product;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_authenticated_can_update_document()
    {
        $product = Product::factory()->create();

        $response = $this->json(
            'PUT',
            route('admin.product.document.update', $product),
            [
                'documents' => $documents = [
                    [
                        'name' => 'test',
                        'source' => DocumentSource::URL,
                        'url' => 'http://www.test.com',
                        'type' => DocumentType::MANUAL,
                        'position' => 1
                    ],
                    [
                        'name' => 'test_2',
                        'source' => DocumentSource::FILE,
                        'file' => UploadedFile::fake()->create('test.pdf'),
                        'type' => DocumentType::MANUAL,
                    ],
                ]
            ],
        );

        $response->assertNoContent();
    }
}
