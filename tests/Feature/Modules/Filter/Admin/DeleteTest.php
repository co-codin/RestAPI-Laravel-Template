<?php


namespace Tests\Feature\Modules\Filter\Admin;

use Modules\Filter\Models\Filter;
use Tests\TestCase;

class DeleteTest extends TestCase
{
//    public function test_unauthenticated_cannot_delete_filter()
//    {
//        //
//    }

    public function test_authenticated_can_delete_filter()
    {
        $filter = Filter::factory()->create();

        $response = $this->deleteJson(route('admin.filters.destroy', $filter));

        $response->assertNoContent();

        $this->assertDeleted($filter);
    }
}
