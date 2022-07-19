<?php


namespace Tests\Feature\Modules\Vacancy\Admin;


use Modules\Role\Models\Permission;
use Modules\User\Models\User;
use Modules\Vacancy\Enums\VacancyPermission;
use Modules\Vacancy\Models\Vacancy;
use Tests\TestCase;

class CreateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $createPermission = Permission::factory()->create([
            'name' => VacancyPermission::CREATE_VACANCIES
        ]);

        $user->givePermissionTo($createPermission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_create_a_vacancy()
    {
        $vacancyData = Vacancy::factory()->raw();

        $response = $this->json('POST', route('admin.vacancies.store'), $vacancyData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
            ]
        ]);
        $this->assertDatabaseHas('vacancies', [
            'name' => $vacancyData['name'],
        ]);
    }
}
