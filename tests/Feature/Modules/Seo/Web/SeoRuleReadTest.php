<?php


namespace Tests\Feature\Modules\Seo\Web;

use Modules\Seo\Models\SeoRule;
use Tests\TestCase;
use function route;

class SeoRuleReadTest extends TestCase
{
    public function test_user_can_view_seo_rules()
    {
        SeoRule::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('seo-rules.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "url",
                    "created_at",
                    "updated_at",
                ]
            ],
            'links' => [
                "first",
                "last",
                "prev",
                "next",
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [
                    [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'path',
                'per_page',
                'to',
                'total',
            ]
        ]);
    }

    public function test_user_can_view_single_seo_rule()
    {
        $seoRule = SeoRule::factory()->create();

        $response = $this->json('GET', route('seo-rules.show', $seoRule));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "url",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}
