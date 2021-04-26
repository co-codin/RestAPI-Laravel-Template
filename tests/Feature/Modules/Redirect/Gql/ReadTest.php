<?php

namespace Tests\Feature\Modules\Redirect\Gql;

use Modules\Redirect\Models\Redirect;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_redirects_can_be_viewed()
    {
        $redirect = Redirect::factory()->create();

        $response = $this->graphQL('
            {
                redirects {
                    data {
                        id
                        source
                        destination
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
                'redirects' => [
                    'data' => [
                        [
                            'id' => $redirect->id,
                            'source' => $redirect->source,
                            'destination' => $redirect->destination,
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
                redirects(where: { column: ID, operator: EQ, value: ' . $redirect->id .'  }) {
                    data {
                        id
                        source
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'redirects' => [
                    'data' => [
                        [
                            'id' => $redirect->id,
                            'source' => $redirect->source,
                        ]
                    ],
                ]
            ],
        ]);

    }
}
