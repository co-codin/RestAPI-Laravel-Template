<?php


namespace Tests\Feature\Modules\Redirect\Admin;


use Modules\Redirect\Models\Redirect;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_redirect()
    {
        //
    }

    public function test_authenticated_can_update_redirect()
    {
        $redirect = Redirect::factory()->create();

        $response = $this->json('PATCH', route('admin.redirects.update', $redirect), [
            'old_url' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('redirects', [
            'old_url' => $newName,
        ]);
    }
}
