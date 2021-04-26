<?php


namespace Tests\Feature\Modules\Filter\Admin;

use Modules\Category\Models\Category;
use Modules\Filter\Models\Filter;
use Tests\TestCase;

class UpdateTest extends TestCase
{
//    public function test_unauthenticated_cannot_update_filter()
//    {
//        //
//    }

    public function test_authenticated_user_can_update_filter()
    {
        $filter = Filter::factory()->create();

        $response = $this->json('PATCH', route('admin.filters.update', $filter), [
            'name' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('filters', [
            'name' => $newName,
        ]);
    }

    public function test_authenticated_user_can_only_update_filter_with_category_id_and_slug()
    {
        $filter = Filter::factory()->create();
        $category = Category::factory()->create();

        $this->json('PATCH', route('admin.filters.update', $filter), [
            'category_id' => $category->id,
        ])->assertStatus(422);

        $this->json('PATCH', route('admin.filters.update', $filter), [
            'category_id' => $category->id,
            'slug' => $newSlug = 'newslug',
        ])->assertOk();

        $this->assertDatabaseHas('filters', [
            'slug' => $newSlug,
        ]);
    }
}
