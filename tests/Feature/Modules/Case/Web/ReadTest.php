<?php

namespace Tests\Feature\Modules\Case\Web;

use Modules\Case\Models\CaseModel;
use Tests\TestCase;

class ReadTest extends TestCase
{
    public function test_user_can_view_cases()
    {
        CaseModel::factory()->count($count = 5)->create();

        $response = $this->json('GET', route('cases.index'));

        $response->assertOk();

        $this->assertEquals($count, count(($response['data'])));

        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'slug',
                    'short_description',
                    'full_description',
                    'image',
                    'status',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }

    public function test_user_can_view_single_case()
    {
        $case = CaseModel::factory()->create();

        $response = $this->json('GET', route('cases.show', $case));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'slug',
                'short_description',
                'full_description',
                'image',
                'status',
                'created_at',
                'updated_at',
            ]
        ]);
    }
}
