<?php


namespace Tests\Feature\Modules\Faq\Admin\QuestionCategory;


use Modules\Faq\Models\QuestionCategory;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_unauthenticated_cannot_create_question_category()
    {
        $questionCategoryData = QuestionCategory::factory()->raw();

        $response = $this->json('POST', route('admin.question-categories.store'), $questionCategoryData);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_create_question_category()
    {
        $this->authenticateUser();

        $questionCategoryData = QuestionCategory::factory()->raw();

        $response = $this->json('POST', route('admin.question-categories.store'), $questionCategoryData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'slug',
            ]
        ]);
        $this->assertDatabaseHas('question_categories', [
            'name' => $questionCategoryData['name'],
        ]);
    }
}
