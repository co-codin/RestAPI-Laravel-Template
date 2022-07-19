<?php


namespace Tests\Feature\Modules\Vacancy\Admin;


use App\Enums\Status;
use Modules\Role\Models\Permission;
use Modules\User\Models\User;
use Modules\Vacancy\Enums\VacancyPermission;
use Modules\Vacancy\Models\Vacancy;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $deletePermission = Permission::factory()->create([
            'name' => VacancyPermission::EDIT_VACANCIES
        ]);

        $user->givePermissionTo($deletePermission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_update_vacancy()
    {
        $vacancy = Vacancy::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->json('PATCH', route('admin.vacancies.update', [$vacancy]), [
            'name' => $newName = 'new name',
            'slug' => 'test-slug',
            'status' => Status::INACTIVE
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('vacancies', [
            'name' => $newName,
            'slug' => 'test-slug',
            'status' => Status::INACTIVE
        ]);
    }
}
