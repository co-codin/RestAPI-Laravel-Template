<?php


namespace Tests\Feature\Modules\Seo\Web;

use Modules\Seo\Models\SeoRule;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_active_seo_rules_can_be_viewed()
    {
        $seoRule = SeoRule::factory()->create();

        $response = $this->graphQL('
            {
                seo_rules {
                    data {
                        id
                        name
                        url
                    }
                    paginatorInfo {
                        currentPage
                        lastPage
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'seo_rules' => [
                    'data' => [
                        [
                            'id' => $seoRule->id,
                            'name' => $seoRule->name,
                        ]
                    ],
                    'paginatorInfo' => [
                        'currentPage' => 1,
                        'lastPage' => 1,
                    ]
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                seo_rules(where: { column: ID, operator: EQ, value: ' . $seoRule->id .'  }) {
                    data {
                        id
                        name
                        url
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'seo_rules' => [
                    'data' => [
                        [
                            'id' => $seoRule->id,
                            'name' => $seoRule->name,
                        ]
                    ],
                ]
            ],
        ]);

    }
}
