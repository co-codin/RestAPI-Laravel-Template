<?php


namespace Tests\Feature\Modules\Vacancy\Gql;


use App\Enums\Status;
use Modules\Vacancy\Models\Vacancy;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_vacancies_can_be_viewed()
    {
        $vacancy = Vacancy::factory()->create();

        $response = $this->graphQL('
            {
                vacancies {
                   id
                   name
                   slug
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'vacancies' => [
                    [
                        'id' => $vacancy->id,
                        'name' => $vacancy->name,
                    ]
                ]
            ],
        ]);

        $response = $this->graphQL('
            {
                vacancies(where: { column: ID, operator: EQ, value: ' . $vacancy->id .'  }) {
                    id
                    name
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'vacancies' => [
                    [
                        'id' => $vacancy->id,
                        'name' => $vacancy->name,
                    ]
                ]
            ],
        ]);

    }
}
