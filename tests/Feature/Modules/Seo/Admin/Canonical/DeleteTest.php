<?php


namespace Tests\Feature\Modules\Seo\Admin\Canonical;

use Modules\Seo\Models\Canonical;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_authenticated_can_delete_canonical()
    {
        $this->authenticateUser();

        $canonical = Canonical::factory()->create();

        $response = $this->json('DELETE', route('admin.canonicals.destroy', $canonical));

        $response->assertNoContent();

        $this->assertDeleted($canonical);
    }
}
