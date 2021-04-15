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
                        old_url
                        new_url
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
                            'old_url' => $redirect->old_url,
                            'new_url' => $redirect->new_url,
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
                        old_url
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
                            'old_url' => $redirect->old_url,
                        ]
                    ],
                ]
            ],
        ]);

    }
}
