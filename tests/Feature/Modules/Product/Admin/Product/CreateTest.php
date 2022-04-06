<?php


namespace Tests\Feature\Modules\Product\Admin\Product;

use App\Models\FieldValue;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Category\Models\Category;
use Modules\Product\Enums\DocumentSource;
use Modules\Product\Enums\DocumentType;
use Modules\Product\Models\Product;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_product()
    {
        return true;

//        $this->authenticateUser();
//
//        $category = Category::factory()->create();
//
//        $productData = Product::factory()->raw();
//
//        $response = $this->json('POST', route('admin.products.store'), array_merge($productData, [
//            'categories' => [
//                ['id' => $category->id, 'is_main' => $isMain = true]
//            ],
//        ]));
//
//        $response->assertCreated();
//        $response->assertJsonStructure([
//            'data' => [
//                'name',
//                'slug',
//            ]
//        ]);
//
//        $this->assertDatabaseHas('products', [
//            'name' => $productData['name'],
//            'slug' => $productData['slug']
//        ]);
//
//        $this->assertDatabaseHas('product_category', [
//            'product_id' => $response['data']['id'],
//            'category_id' => $category->id,
//            'is_main' => $isMain,
//        ]);
    }

    public function test_authenticated_can_create_with_documents_in_product()
    {
        return true;
//        $this->authenticateUser();
//
//        $category = Category::factory()->create();
//
//        $productData = Product::factory()->raw([
//            'documents' => $documents = [
//                [
//                    'name' => 'test',
//                    'source' => DocumentSource::URL,
//                    'url' => 'https://www.test.com',
//                    'type' => DocumentType::MANUAL,
//                    'position' => 1
//                ],
//                [
//                    'name' => 'test_2',
//                    'source' => DocumentSource::FILE,
//                    'file' => $file = UploadedFile::fake()->createWithContent('test.pdf', 'test'),
//                    'type' => DocumentType::MANUAL,
//                ],
//            ]
//        ]);
//
//        $response = $this->json('POST', route('admin.products.store'), array_merge($productData, [
//            'categories' => [
//                ['id' => $category->id, 'is_main' => true]
//            ],
//        ]));
//
//        $response->assertCreated();
//        $response->assertJsonStructure([
//            'data' => [
//                'name',
//                'slug',
//                'documents',
//            ]
//        ]);
//
//        $response->assertJson(fn (AssertableJson $json) =>
//            $json
//                ->has('data.documents', count($documents))
//                ->has('data.documents.0', fn ($json) =>
//                    $json->where('name', 'test')
//                        ->where('url', 'http://www.test.com')
//                        ->etc()
//                )
//                ->has('data.documents.1', fn ($json) =>
//                $json->where('name', 'test_2')
//                    ->where('file', date('Y') . '/' . date('m') . '/' . $file->hashName())
//                    ->etc()
//                )
//        );
//
//        $this->assertDatabaseHas('products', [
//            'name' => $productData['name'],
//            'slug' => $productData['slug'],
//        ]);
    }
}
