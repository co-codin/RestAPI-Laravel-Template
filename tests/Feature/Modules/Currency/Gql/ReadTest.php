<?php


namespace Tests\Feature\Modules\Currency\Gql;


use Modules\Currency\Models\Currency;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_currencies_can_be_viewed()
    {
        $currency = Currency::factory()->create();

        $response = $this->graphQL('
            {
                currencies {
                    data {
                        id
                        name
                        code
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
                'currencies' => [
                    'data' => [
                        [
                            'id' => $currency->id,
                            'name' => $currency->name,
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
                currencies(where: { column: ID, operator: EQ, value: ' . $currency->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'currencies' => [
                    'data' => [
                        [
                            'id' => $currency->id,
                            'name' => $currency->name,
                        ]
                    ],
                ]
            ],
        ]);

    }
}
