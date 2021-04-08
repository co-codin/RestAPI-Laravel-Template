<?php


namespace Tests\Feature\Modules\Faq\Admin\Question;


use Modules\Faq\Models\Question;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_question_category()
    {
        //
    }

    public function test_authenticated_can_delete_question()
    {
        $question = Question::factory()->create();

        $response = $this->json('DELETE', route('admin.questions.destroy', ['question' => $question->id]));

        $response->assertStatus(204);

        $this->assertSoftDeleted('questions', [
            'question' => $question->question,
        ]);
    }
}
