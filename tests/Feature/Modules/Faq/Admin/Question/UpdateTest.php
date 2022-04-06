<?php


namespace Tests\Feature\Modules\Faq\Admin\Question;


use App\Enums\Status;
use Modules\Faq\Models\Question;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_authenticated_can_update_a_question()
    {
        $this->authenticateUser();

        $question = Question::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->json('PATCH', route('admin.questions.update', $question), [
            'question' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('questions', [
            'question' => $newName,
        ]);
    }
}
