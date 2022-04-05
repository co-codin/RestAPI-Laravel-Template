<?php


namespace Tests\Feature\Modules\Faq\Admin\Question;


use Modules\Faq\Models\Question;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_a_question()
    {
        $question = Question::factory()->create();

        $response = $this->deleteJson(route('admin.questions.destroy', $question));

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_delete_a_question()
    {
        $this->authenticateUser();

        $question = Question::factory()->create();

        $response = $this->deleteJson(route('admin.questions.destroy', $question));

        $response->assertNoContent();

        $this->assertSoftDeleted($question);
    }
}
