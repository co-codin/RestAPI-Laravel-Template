<?php


namespace Tests\Feature\Modules\Seo\Admin\Canonical;

use Modules\Seo\Models\Canonical;
use Tests\TestCase;

class UpdateTest extends TestCase
{
//    public function test_unauthenticated_cannot_update_canonical()
//    {
//        //
//    }

    public function test_authenticated_can_update_canonical()
    {
        $canonical = Canonical::factory()->create();

        $response = $this->json('PATCH',
            route('admin.canonicals.update', $canonical), [
                'canonical' => $newName = 'new canonical',
            ]
        );

        $response->assertOk();
        $this->assertDatabaseHas('canonicals', [
            'canonical' => $newName,
        ]);
    }
}
