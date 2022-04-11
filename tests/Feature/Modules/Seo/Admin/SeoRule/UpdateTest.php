<?php


namespace Tests\Feature\Modules\Seo\Admin\SeoRule;

use Modules\Publication\Models\Publication;
use Modules\Seo\Models\SeoRule;
use Tests\TestCase;
use function route;

class UpdateTest extends TestCase
{
    public function test_authenticated_can_update_seo_rule()
    {
        $this->authenticateUser();

        $seoRule = SeoRule::factory()->create();

        $response = $this->json('PATCH', route('admin.seo-rules.update', $seoRule), [
            'name' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('seo_rules', [
            'name' => $newName,
        ]);
    }
}
