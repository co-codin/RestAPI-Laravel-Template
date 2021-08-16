<?php


namespace Tests\Feature\Modules\Export\Admin;


use Modules\Export\Models\Export;
use Tests\TestCase;

class DeleteTest extends TestCase
{
//    public function test_unauthenticated_cannot_delete_export()
//    {
//        //
//    }

    public function test_authenticated_can_delete_export()
    {
        $export = Export::factory()->create();

        $response = $this->deleteJson(route('admin.exports.destroy', $export));

        $response->assertNoContent();

        $this->assertDeleted($export);
    }
}
