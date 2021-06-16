<?php


namespace Tests\Feature\Modules\Export\Gql;


use Modules\Export\Models\Export;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_exports_can_be_viewed()
    {
        $export = Export::factory()->create();

        $response = $this->graphQL('
            {
                exports {
                    data {
                        id
                        name
                        filename
                        type
                        frequency
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
                'exports' => [
                    'data' => [
                        [
                            'id' => $export->id,
                            'name' => $export->name,
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
                exports(where: { column: ID, operator: EQ, value: ' . $export->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'exports' => [
                    'data' => [
                        [
                            'id' => $export->id,
                            'name' => $export->name,
                        ]
                    ],
                ]
            ],
        ]);

    }
}
