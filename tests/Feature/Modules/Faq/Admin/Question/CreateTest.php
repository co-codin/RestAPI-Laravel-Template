<?php


namespace Tests\Feature\Modules\Faq\Admin\Question;


use Modules\Faq\Models\Question;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_user_can_create_a_question()
    {
        $this->authenticateUser();

        $questionData = Question::factory()->raw();

        $response = $this->json('POST', route('admin.questions.store'), $questionData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'question',
                'slug',
            ]
        ]);
        $this->assertDatabaseHas('questions', [
            'question' => $questionData['question'],
        ]);
    }
}
