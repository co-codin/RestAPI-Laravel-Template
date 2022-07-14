<?php


namespace Tests\Feature\Modules\Role\Admin\Role;


use Modules\Redirect\Models\Redirect;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_authenticated_can_delete_redirect()
    {
        $this->authenticateUser();

        $redirect = Redirect::factory()->create();

        $response = $this->json('DELETE', route('admin.redirects.destroy', $redirect));

        $response->assertNoContent();

        $this->assertDeleted($redirect);
    }
}
