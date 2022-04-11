<?php


namespace Tests\Feature\Modules\Redirect\Admin;


use Modules\Redirect\Models\Redirect;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_redirect()
    {
        $this->authenticateUser();

        $redirectData = Redirect::factory()->raw();

        $response = $this->json('POST', route('admin.redirects.store'), $redirectData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'destination',
                'source',
                'code',
            ]
        ]);
        $this->assertDatabaseHas('redirects', [
            'destination' => $redirectData['destination'],
            'source' => $redirectData['source'],
        ]);
    }
}
