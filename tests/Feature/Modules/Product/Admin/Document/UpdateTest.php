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
        $this->withoutExceptionHandling();

//        Storage::fake('documents');

        $product = Product::factory()->create([
            'image' => UploadedFile::fake()->image('test.jpg'),
        ]);

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
                        'file' => $file = UploadedFile::fake()->createWithContent('test.pdf', 'test'),
                        'type' => DocumentType::MANUAL,
                    ],
                ]
            ],
        );

        $response->assertOk();
        $this->assertNotEmpty($product->refresh()->documents);
    }
}
