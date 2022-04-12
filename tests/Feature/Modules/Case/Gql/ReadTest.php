<?php


namespace Tests\Feature\Modules\Case\Gql;

use Modules\Case\Models\CaseModel;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_case_models_can_be_viewed()
    {
        $case = CaseModel::factory()->create();

        $response = $this->graphQL('
            {
                case_models {
                    data {
                        id
                        name
                        slug
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
                'case_models' => [
                    'data' => [
                        [
                            'id' => $case->id,
                            'name' => $case->name,
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
                case_models(where: { column: ID, operator: EQ, value: ' . $case->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'case_models' => [
                    'data' => [
                        [
                            'id' => $case->id,
                            'name' => $case->name,
                        ]
                    ],
                ]
            ],
        ]);

    }
}
