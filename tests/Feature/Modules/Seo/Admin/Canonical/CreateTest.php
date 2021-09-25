<?php


namespace Tests\Feature\Modules\Seo\Admin\Canonical;

use Modules\Seo\Models\Canonical;
use Tests\TestCase;

class CreateTest extends TestCase
{
//    public function test_unauthenticated_cannot_create_canonical()
//    {
//        //
//    }

    public function test_authenticated_can_create_canonical()
    {
        $canonicalData = Canonical::factory()->raw();

        $response = $this->json('POST', route('admin.canonicals.store'), $canonicalData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'url',
                'canonical',
            ]
        ]);

        $this->assertDatabaseHas('canonicals', [
            'url' => $canonicalData['url'],
            'canonical' => $canonicalData['canonical'],
        ]);
    }
}
