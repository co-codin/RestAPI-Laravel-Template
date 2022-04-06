<?php


namespace Tests\Feature\Modules\Attribute\Admin;

use Modules\Attribute\Models\Attribute;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_authenticated_can_update_attribute()
    {
        $this->authenticateUser();

        $achievement = Attribute::factory()->create([
            'is_default' => true,
        ]);

        $response = $this->json('PATCH', route('admin.attributes.update', $achievement), [
            'name' => $newName = 'new name',
            'is_default' => false
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('attributes', [
            'name' => $newName,
            'is_default' => false
        ]);
    }
}
