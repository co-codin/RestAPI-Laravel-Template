<?php


namespace Tests\Feature\Modules\Page\Admin;

use Modules\Page\Models\Page;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_page()
    {
        $this->authenticateUser();

        $pageData = Page::factory()->raw();

        $response = $this->json('POST', route('admin.pages.store'), $pageData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
            ]
        ]);
        $this->assertDatabaseHas('pages', [
            'name' => $pageData['name'],
        ]);
    }
}
