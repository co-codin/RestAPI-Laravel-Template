<?php


namespace Tests\Feature\Modules\Filter\Admin;

use Modules\Filter\Models\Filter;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_authenticated_can_create_filter()
    {
        $this->authenticateUser();

        $filterData = Filter::factory()->raw();

        $response = $this->json('POST', route('admin.filters.store'), $filterData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'slug',
            ]
        ]);

        $this->assertDatabaseHas('filters', [
            'name' => $filterData['name'],
        ]);
    }
}
