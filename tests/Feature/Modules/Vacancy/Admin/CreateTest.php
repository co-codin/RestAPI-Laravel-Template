<?php


namespace Tests\Feature\Modules\Vacancy\Admin;


use Illuminate\Http\UploadedFile;
use Modules\Vacancy\Models\Vacancy;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_a_vacancy()
    {
        $this->authenticateUser();

        $vacancyData = Vacancy::factory()->raw();

        $response = $this->json('POST', route('admin.vacancies.store'), $vacancyData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'slug',
            ]
        ]);
        $this->assertDatabaseHas('vacancies', [
            'name' => $vacancyData['name'],
        ]);
    }
}
