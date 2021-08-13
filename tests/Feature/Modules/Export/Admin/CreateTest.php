<?php


namespace Tests\Feature\Modules\Export\Admin;


use Modules\Export\Models\Export;
use Tests\TestCase;

class CreateTest extends TestCase
{
//    public function test_unauthenticated_cannot_create_export()
//    {
//        //
//    }

    public function test_authenticated_can_create_export()
    {
        $exportData = Export::factory()->raw();

        $response = $this->json('POST', route('admin.exports.store'), $exportData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'type',
                'filename'
            ]
        ]);
        $this->assertDatabaseHas('exports', [
            'name' => $exportData['name'],
        ]);
    }
}
