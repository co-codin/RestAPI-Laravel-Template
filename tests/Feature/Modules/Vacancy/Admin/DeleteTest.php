<?php


namespace Tests\Feature\Modules\Vacancy\Admin;


use Modules\Role\Models\Permission;
use Modules\User\Models\User;
use Modules\Vacancy\Enums\VacancyPermission;
use Modules\Vacancy\Models\Vacancy;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $deletePermission = Permission::factory()->create([
            'name' => VacancyPermission::DELETE_VACANCIES
        ]);

        $user->givePermissionTo($deletePermission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    public function test_authenticated_can_delete_vacancy()
    {
        $vacancy = Vacancy::factory()->create();

        $response = $this->json('DELETE', route('admin.vacancies.destroy', $vacancy));

        $response->assertNoContent();

        $this->assertSoftDeleted($vacancy);
    }
}
