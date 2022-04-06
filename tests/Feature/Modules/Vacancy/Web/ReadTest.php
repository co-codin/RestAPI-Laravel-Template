<?php


namespace Tests\Feature\Modules\Vacancy\Web;


use Modules\Vacancy\Models\Vacancy;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_vacancies()
    {
        Vacancy::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('vacancies.index'));

        $response->assertOk();
        $this->assertEquals($count, count(($response['data'])));
        $response->assertJsonStructure([
            'data' => [
                [
                    "id",
                    "name",
                    "slug",
                    "short_description",
                    "status",
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

    public function test_user_can_view_single_vacancy()
    {
        $vacancy = Vacancy::factory()->create();

        $response = $this->json('GET', route('vacancies.show', $vacancy));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "slug",
                "short_description",
                "status",
                "created_at",
                "updated_at",
            ]
        ]);
    }
}
