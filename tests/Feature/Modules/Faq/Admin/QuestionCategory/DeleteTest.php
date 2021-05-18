<?php


namespace Tests\Feature\Modules\Faq\Admin\QuestionCategory;


use Modules\Faq\Models\QuestionCategory;
use Tests\TestCase;

class DeleteTest extends TestCase
{
//    public function test_unauthenticated_cannot_delete_question_category()
//    {
//        //
//    }

    public function test_authenticated_can_delete_question_category()
    {
        $questionCategory = QuestionCategory::factory()->create();

        $response = $this->deleteJson(route('admin.question-categories.destroy', $questionCategory));

        $response->assertNoContent(204);

        $this->assertSoftDeleted($questionCategory);
    }
}
