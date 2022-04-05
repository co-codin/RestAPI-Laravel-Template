<?php


namespace Tests\Feature\Modules\Faq\Admin\QuestionCategory;


use Modules\Faq\Models\QuestionCategory;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_question_category()
    {
        $questionCategory = QuestionCategory::factory()->create();

        $response = $this->deleteJson(route('admin.question-categories.destroy', $questionCategory));

        $response->assertStatus(401);
    }

    public function test_authenticated_can_delete_question_category()
    {
        $this->authenticateUser();

        $questionCategory = QuestionCategory::factory()->create();

        $response = $this->deleteJson(route('admin.question-categories.destroy', $questionCategory));

        $response->assertNoContent();

        $this->assertSoftDeleted($questionCategory);
    }
}
