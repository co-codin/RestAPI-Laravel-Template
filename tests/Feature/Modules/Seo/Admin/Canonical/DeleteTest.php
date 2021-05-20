<?php


namespace Tests\Feature\Modules\Seo\Admin\Canonical;

use Modules\Seo\Models\CanonicalEntity;
use Tests\TestCase;

class DeleteTest extends TestCase
{
//    public function test_unauthenticated_cannot_delete_canonical()
//    {
//        //
//    }

    public function test_authenticated_can_delete_canonical()
    {
        $canonical = CanonicalEntity::factory()->create();

        $response = $this->json('DELETE', route('admin.canonicals.destroy', $canonical));

        $response->assertNoContent();

        $this->assertDeleted($canonical);
    }
}
