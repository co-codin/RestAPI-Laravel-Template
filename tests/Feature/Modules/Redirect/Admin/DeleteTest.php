<?php


namespace Tests\Feature\Modules\Redirect\Admin;


use Modules\Redirect\Models\Redirect;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_redirect()
    {
        //
    }

    public function test_authenticated_can_delete_redirect()
    {
        $redirect = Redirect::factory()->create();

        $response = $this->json('DELETE', route('admin.redirects.destroy', $redirect));

        $response->assertNoContent();

        $this->assertDeleted($redirect);
    }
}
