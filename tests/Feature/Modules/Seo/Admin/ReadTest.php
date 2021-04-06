<?php


namespace Tests\Feature\Modules\Seo\Admin;

use Modules\Seo\Models\SeoRule;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_unauthenticated_user_cannot_view_any_seo_rule()
    {

    }

    public function test_authenticated_user_can_view_seo_rules()
    {
        SeoRule::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('admin.seo-rules.index'));

        $response->assertStatus(200);
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

    public function test_authenticated_user_can_view_single_seo_rule()
    {
        $seoRule = SeoRule::factory()->create();

        $response = $this->json('GET', route('admin.seo-rules.show', ['seo_rule' => $seoRule->id]));

        $response->assertStatus(200);
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
