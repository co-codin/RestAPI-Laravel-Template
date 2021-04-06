<?php


namespace Tests\Feature\Modules\Faq\Admin\Question;


use Modules\Faq\Models\Question;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_unauthenticated_cannot_create_question()
    {
        //
    }

    public function test_authenticated_can_create_question()
    {
        $questionData = Question::factory()->raw();

        $response = $this->json('POST', route('admin.questions.store'), $questionData);

        $response->assertStatus(201);
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
