<?php


namespace Tests\Feature\Modules\Currency\Admin;

use Modules\Currency\Models\Currency;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_authenticated_can_delete_currency()
    {
        $this->authenticateUser();

        $currency = Currency::factory()->create();

        $response = $this->deleteJson(route('admin.currencies.destroy', $currency));

        $response->assertNoContent();

        $this->assertSoftDeleted($currency);
    }
}
