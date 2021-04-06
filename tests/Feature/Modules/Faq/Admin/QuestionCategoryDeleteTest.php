<?php


namespace Tests\Feature\Modules\Faq\Admin;


use Modules\Faq\Models\QuestionCategory;
use Tests\TestCase;

class QuestionCategoryDeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_question_category()
    {
        //
    }

    public function test_authenticated_can_delete_question_category()
    {
        $questionCategory = QuestionCategory::factory()->create();

        $response = $this->json('DELETE', route('admin.question_categories.destroy', ['question_category' => $questionCategory->id]));

        $response->assertStatus(204);

        $this->assertSoftDeleted('question_categories', [
            'name' => $questionCategory->name,
        ]);
    }
}
