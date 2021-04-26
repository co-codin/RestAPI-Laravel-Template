<?php


namespace Tests\Feature\Modules\Publication\Admin;

use Modules\Publication\Models\Publication;
use Tests\TestCase;

class CreateTest extends TestCase
{
//    public function test_unauthenticated_cannot_create_publication()
//    {
//        //
//    }

    public function test_authenticated_can_create_publication()
    {
        $publicationData = Publication::factory()->raw();

        $response = $this->json('POST', route('admin.publications.store'), $publicationData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'url',
                'is_enabled',
            ]
        ]);
        $this->assertDatabaseHas('publications', [
            'name' => $publicationData['name'],
            'url' => $publicationData['url'],
            'is_enabled' => $publicationData['is_enabled']
        ]);
    }
}
