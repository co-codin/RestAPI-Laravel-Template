<?php


namespace Tests\Feature\Modules\Seo\Admin;

use Modules\Publication\Models\Publication;
use Modules\Seo\Models\SeoRule;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_seo_rule()
    {
        //
    }

    public function test_authenticated_can_update_seo_rule()
    {
        $seoRule = SeoRule::factory()->create();

        $response = $this->json('PATCH', route('admin.seo-rules.update', ['seo_rule' => $seoRule->id]), [
            'name' => $newName = 'new name',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('seo_rules', [
            'name' => $newName,
        ]);
    }
}
