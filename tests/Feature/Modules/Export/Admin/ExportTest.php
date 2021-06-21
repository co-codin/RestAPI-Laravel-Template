<?php


namespace Tests\Feature\Modules\Export\Admin;


use Modules\Export\Models\Export;
use Tests\TestCase;

class ExportTest extends TestCase
{
//    public function test_unauthenticated_cannot_export()
//    {
//        //
//    }

    public function test_authenticated_can_export()
    {
        $export = Export::factory()->create();

        $response = $this->json('POST', route('admin.exports.export', $export));

        $response->assertOk();
    }
}
