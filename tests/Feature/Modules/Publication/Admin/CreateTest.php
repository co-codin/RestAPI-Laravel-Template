<?php


namespace Tests\Feature\Modules\Publication\Admin;

use Illuminate\Support\Facades\Storage;
use Modules\Publication\Models\Publication;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_publication()
    {
        $this->authenticateUser();

        $publicationData = Publication::factory()->raw();

        $response = $this->json('POST', route('admin.publications.store'), $publicationData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'url',
                'is_enabled',
                'logo'
            ]
        ]);
        $this->assertDatabaseHas('publications', [
            'name' => $publicationData['name'],
            'url' => $publicationData['url'],
            'is_enabled' => $publicationData['is_enabled'],
        ]);
        $this->assertTrue(Storage::disk('public')->has($response['data']['logo']));
    }
}
