<?php


namespace Tests\Feature\Modules\Seo\Gql;

use Modules\Seo\Models\Canonical;
use Tests\TestCase;

class CanonicalReadTest extends TestCase
{
    public function test_canonicals_can_be_viewed(): void
    {
        $canonical = Canonical::factory()->create();

        $response = $this->graphQL('
            {
                canonicals {
                    data {
                        id
                        url
                        canonical
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
                'canonicals' => [
                    'data' => [
                        [
                            'id' => $canonical->id,
                            'canonical' => $canonical->canonical,
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
                canonicals(where: { column: ID, operator: EQ, value: ' . $canonical->id .'  }) {
                    data {
                        id
                        url
                        canonical
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'canonicals' => [
                    'data' => [
                        [
                            'id' => $canonical->id,
                            'canonical' => $canonical->canonicals,
                        ]
                    ],
                ]
            ],
        ]);
    }
}
