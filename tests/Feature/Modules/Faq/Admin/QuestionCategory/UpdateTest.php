<?php


namespace Tests\Feature\Modules\Faq\Admin\QuestionCategory;


use App\Enums\Status;
use Modules\Faq\Models\QuestionCategory;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_question_category()
    {
        //
    }

    public function test_authenticated_can_update_question_category()
    {
        $questionCategory = QuestionCategory::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->json('PATCH', route('admin.question_categories.update', ['question_category' => $questionCategory->id]), [
            'name' => $newName = 'new name',
            'status' => Status::ACTIVE,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('question_categories', [
            'name' => $newName,
        ]);
    }
}
