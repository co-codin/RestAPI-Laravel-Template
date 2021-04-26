<?php


namespace Tests\Feature\Modules\Publication\Admin;

use Modules\Publication\Models\Publication;
use Tests\TestCase;

class DeleteTest extends TestCase
{
//    public function test_unauthenticated_cannot_delete_publication()
//    {
//        //
//    }

    public function test_authenticated_can_delete_publication()
    {
        $publication = Publication::factory()->create();

        $response = $this->deleteJson(route('admin.publications.destroy', $publication));

        $response->assertNoContent();

        $this->assertDeleted($publication);
    }
}
