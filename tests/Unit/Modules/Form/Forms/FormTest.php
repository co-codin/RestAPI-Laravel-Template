<?php

namespace Tests\Unit\Modules\Form\Forms;

use App\Helpers\DirectoryHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Modules\Category\Models\Category;
use Modules\Form\Forms\Form;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductCategory;
use Tests\TestCase;

class FormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Collection|Form[]|null
     */
    protected static ?Collection $forms;

    public function setUp(): void
    {
        parent::setUp();

        if (is_null(self::$forms)) {
            $models = DirectoryHelper::getFormClasses()->map(fn (string $class) => new $class);

            self::$forms = $models;
        }
    }

    public function testGetName()
    {
        $forms = self::$forms;

        foreach ($forms as $form) {
            $name = $form::getName();

            $this->assertIsString($name);
            $this->assertSame($name, class_basename($form));
        }
    }

    public function testGetCategory()
    {
        $forms = self::$forms;

        $categoryRoot = Category::factory()->create(['parent_id' => null]);
        $category = Category::factory()->create(['parent_id' => $categoryRoot->id]);

        foreach ($forms as $form) {
            $categoryRule = \Arr::get($form->rules(), 'category');
            $productRule = \Arr::get($form->rules(), 'product');

            if (!is_null($categoryRule)) {
                $form = $form->setAttributes(['category' => $category->slug]);
            }

            if (!is_null($productRule)) {
                $product = Product::factory()->create();

                ProductCategory::factory()->create([
                    'product_id' => $product->id,
                    'category_id' => $category->id,
                    'is_main' => true,
                ]);

                $form = $form->setAttributes(['product' => $product->id]);
            }

            if (!is_null($categoryRule) || !is_null($productRule)) {
                $this->assertEquals($form->getCategory()->id, $categoryRoot->id);
            } else {
                $this->assertNull($form->getCategory());
            }
        }
    }

    public function testIsTestRequest()
    {
        $testPatterns = config('form.test_patterns');
        $forms = self::$forms;

        foreach ($forms as $form) {
            $form
                ->setAttributes([
                    'phone' => $testPatterns['phones'][0],
                    'email' => $testPatterns['emails'][0],
                ]);

            $this->assertTrue($form->isTestRequest());

            $form
                ->fill([
                    'phone' => '1111111',
                    'email' => '111111',
                ]);

            $isTestRequest = $form->isTestRequest();
            $response = $form->response();

            $this->assertFalse($isTestRequest);
            $this->assertIsBool($isTestRequest);
            $this->assertArrayHasKey('isTestRequest', $response);
            $this->assertEquals($isTestRequest, $response['isTestRequest']);
        }
    }
}
