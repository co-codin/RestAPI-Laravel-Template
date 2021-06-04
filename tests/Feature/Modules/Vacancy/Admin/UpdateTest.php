<?php


namespace Tests\Feature\Modules\Vacancy\Admin;


use App\Enums\Status;
use Modules\Vacancy\Models\Vacancy;
use Tests\TestCase;

class UpdateTest extends TestCase
{
//    public function test_unauthenticated_cannot_update_vacancy()
//    {
//        //
//    }

    public function test_authenticated_can_update_vacancy()
    {
        $vacancy = Vacancy::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->json('PATCH', route('admin.vacancies.update', $vacancy), [
            'name' => $newName = 'new name',
            'status' => Status::INACTIVE
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('vacancies', [
            'name' => $newName,
            'status' => Status::INACTIVE
        ]);
    }
}
