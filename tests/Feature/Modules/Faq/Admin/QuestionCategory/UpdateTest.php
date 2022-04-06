<?php


namespace Tests\Feature\Modules\Faq\Admin\QuestionCategory;


use App\Enums\Status;
use Modules\Faq\Models\QuestionCategory;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_question_category()
    {
        $questionCategory = QuestionCategory::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->json('PATCH', route('admin.question-categories.update', $questionCategory), [
            'name' => 'new name',
            'status' => Status::ACTIVE,
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_can_update_question_category()
    {
        $this->authenticateUser();

        $questionCategory = QuestionCategory::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->json('PATCH', route('admin.question-categories.update', $questionCategory), [
            'name' => $newName = 'new name',
            'status' => Status::ACTIVE,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('question_categories', [
            'name' => $newName,
        ]);
    }
}
