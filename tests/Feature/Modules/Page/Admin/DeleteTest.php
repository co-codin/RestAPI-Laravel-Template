<?php


namespace Tests\Feature\Modules\Page\Admin;

use Modules\Page\Models\Page;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_authenticated_can_delete_page()
    {
        $this->authenticateUser();

        $page = Page::factory()->create();

        $response = $this->deleteJson(route('admin.pages.destroy', $page));

        $response->assertNoContent();

        $this->assertSoftDeleted($page);
    }
}
