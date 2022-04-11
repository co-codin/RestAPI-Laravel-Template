<?php


namespace Tests\Feature\Modules\Seo\Admin\SeoRule;

use Modules\Seo\Models\SeoRule;
use Tests\TestCase;
use function route;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_seo_rule()
    {
        $this->authenticateUser();

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
