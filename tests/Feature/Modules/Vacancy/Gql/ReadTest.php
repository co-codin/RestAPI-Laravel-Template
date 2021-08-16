<?php


namespace Tests\Feature\Modules\Vacancy\Gql;


use App\Enums\Status;
use Modules\Vacancy\Models\Vacancy;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_vacancies_can_be_viewed()
    {
        $vacancy = Vacancy::factory()->create([
            'status' => Status::INACTIVE,
        ]);

        $response = $this->graphQL('
            {
                vacancies {
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
                'vacancies' => [
                    'data' => [
                        [
                            'id' => $vacancy->id,
                            'name' => $vacancy->name,
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
                vacancies(where: { column: ID, operator: EQ, value: ' . $vacancy->id .'  }) {
                    data {
                        id
                        name
                    }
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'vacancies' => [
                    'data' => [
                        [
                            'id' => $vacancy->id,
                            'name' => $vacancy->name,
                        ]
                    ],
                ]
            ],
        ]);

    }
}
