<?php


namespace Tests\Feature\Modules\Seo\Admin;

use Modules\Seo\Models\SeoRule;
use Tests\TestCase;

class CreateTest extends TestCase
{
//    public function test_unauthenticated_cannot_create_publication()
//    {
//        //
//    }

    public function test_authenticated_can_create_seo_rule()
    {
        $seoRuleData = SeoRule::factory()->raw();

        $response = $this->json('POST', route('admin.seo-rules.store'), $seoRuleData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'url',
            ]
        ]);
        $this->assertDatabaseHas('seo_rules', [
            'name' => $seoRuleData['name'],
            'url' => $seoRuleData['url'],
        ]);
    }
}
