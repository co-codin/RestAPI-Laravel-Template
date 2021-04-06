<?php


namespace Tests\Feature\Modules\Seo\Admin;

use Modules\Seo\Models\SeoRule;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_seo_rule()
    {
        //
    }

    public function test_authenticated_can_delete_seo_rule()
    {
        $seoRule = SeoRule::factory()->create();

        $response = $this->json('DELETE', route('admin.seo-rules.destroy', ['seo_rule' => $seoRule->id]));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('seo_rules', [
            'name' => $seoRule->name,
            'url' => $seoRule->url,
        ]);
    }
}
