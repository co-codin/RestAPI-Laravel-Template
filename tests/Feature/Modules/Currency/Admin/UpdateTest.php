<?php


namespace Tests\Feature\Modules\Currency\Admin;

use Modules\Currency\Models\Currency;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_currency()
    {
        //
    }

    public function test_authenticated_can_update_currency()
    {
        $currency = Currency::factory()->create();

        $response = $this->json('PATCH', route('admin.currencies.update', $currency), [
            'name' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('currencies', [
            'name' => $newName,
        ]);
    }
}
