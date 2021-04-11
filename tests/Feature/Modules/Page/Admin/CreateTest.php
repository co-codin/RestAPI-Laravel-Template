<?php


namespace Tests\Feature\Modules\Page\Admin;

use Modules\Page\Models\Page;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_unauthenticated_cannot_create_page()
    {
        //
    }

    public function test_authenticated_can_create_page()
    {
        $pageData = Page::factory()->raw();

        $response = $this->json('POST', route('admin.pages.store'), $pageData);

        $response->assertStatus(201);
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