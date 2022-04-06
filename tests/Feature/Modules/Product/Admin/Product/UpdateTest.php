<?php


namespace Tests\Feature\Modules\Product\Admin\Product;

use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Product\Enums\DocumentSource;
use Modules\Product\Enums\DocumentType;
use Modules\Product\Models\Product;
use Tests\TestCase;

class UpdateTest extends TestCase
{

    public function test_authenticated_can_update_product()
    {
        $this->authenticateUser();

        $product = Product::factory()->create();

        $response = $this->json('PATCH', route('admin.products.update', $product), [
            'name' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('products', [
            'name' => $newName,
        ]);
    }

    public function test_authenticated_can_update_documents_in_product()
    {
        $product = Product::factory()->create();

        $response = $this->json('PATCH', route('admin.products.update', $product), [
            'name' => $newName = 'new name',
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
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('products', [
            'name' => $newName,
        ]);

        $response->assertJson(fn(AssertableJson $json) => $json
            ->has('data.documents', count($documents))
            ->has('data.documents.0', fn($json) => $json->where('name', 'test')
                ->where('url', 'http://www.test.com')
                ->etc()
            )
            ->has('data.documents.1', fn($json) => $json->where('name', 'test_2')
                ->where('file', date('Y') . '/' . date('m') . '/' . $file->hashName())
                ->etc()
            )
        );
    }
}
