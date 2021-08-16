<?php

namespace Tests\Feature\Modules\Form\Http;

use App\Helpers\DirectoryHelper;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Modules\Brand\Models\Brand;
use Modules\Category\Models\Category;
//use Modules\Client\Models\City;
use Modules\Form\Forms\ChatBot;
use Modules\Form\Forms\Form;
use Modules\Form\Jobs\SendToBitrix;
use Modules\Form\Jobs\SendToCrm;
use Modules\Form\Mail\MailableForm;
use Modules\Product\Models\Product;
use ReflectionProperty;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase, WithoutMiddleware;

    /**
     * @throws \ReflectionException
     * @throws \JsonException
     */
    public function testSend(): void
    {
        Mail::fake();
        Queue::fake();

        $classes = DirectoryHelper::getFormClasses();

        $email = $this->faker->email;
        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
//        $city = City::factory()->create();

        $options = $this->getNotAccessibleProperty(ChatBot::class, 'options');
        $subCategory = array_key_first($options);

        $companyTypes = $this->getNotAccessibleProperty(ChatBot::class, 'companyTypes');
        $companyType = array_key_first($companyTypes);

        foreach ($classes as $class) {
            $response = $this->post('/api/form/send', [
                'formName' => class_basename($class),
                'name' => $this->faker->word,
                'first_name' => $this->faker->word,
                'last_name' => $this->faker->word,
                'email' => $email,
                'message' => $this->faker->word,
                'phone' => '+79995107811',
                'url' => $this->faker->url,
                'product' => $product->id,
                'category' => $category->slug,
                'brand' => $brand->slug,
//                'city' => $city->id,
                'accept' => true,
//                'city-title' => $city->title,
                'company' => $this->faker->word,
                'post' => $this->faker->word,
                'recommend_name' => $this->faker->word,
                'recommend_phone' => '+79995107811',
                'recommend_email' => $this->faker->email,
                'comment' => $this->faker->word,
                'subCategory' => $subCategory,
                'companyType' => $companyType,
                'hasBrand' => 'Да',
            ]);

            Queue::assertPushedOn('form-to-bitrix', SendToBitrix::class);
//            Queue::assertPushedOn('form-to-crm', SendToCrm::class);

            /** @var Form $form */
            $form = app($class);

            Mail::assertQueued(
                MailableForm::class,
                fn (Mailable $mail): bool => $mail->hasTo($form->emails())
            );
            
            $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    'ga',
                    'jsCallback',
                    'jsCallbackReturn',
                    'popupMessage',
                    'popupTitle',
                    'ym',
                    'ym_id',
                ]);

            $content = json_decode($response->content(), false, 512, JSON_THROW_ON_ERROR);

            $this->assertIsBool($content->jsCallbackReturn);
            $this->assertSame($content->jsCallback, class_basename($class));
            $this->assertSame($content->ym_id, config('services.yandex-metrika.id'));
            $this->assertTrue(is_null($content->ym) || is_string($content->ym));
            $this->assertTrue(is_null($content->ga) || is_string($content->ga));
        }
    }

    /**
     * @param string $class
     * @param string $propertyName
     * @return mixed
     * @throws \ReflectionException
     */
    private function getNotAccessibleProperty(string $class, string $propertyName): mixed
    {
        $property = new ReflectionProperty($class, $propertyName);

        if (!$property->isPublic()) {
            $property->setAccessible(true);
        }

        return $property->getValue(new $class);
    }
}
