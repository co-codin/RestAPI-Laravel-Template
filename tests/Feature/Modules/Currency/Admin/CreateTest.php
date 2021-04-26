<?php


namespace Tests\Feature\Modules\Currency\Admin;

use Modules\Currency\Models\Currency;
use Tests\TestCase;

class CreateTest extends TestCase
{
//    public function test_unauthenticated_cannot_create_currency()
//    {
//        //
//    }

    public function test_authenticated_can_create_currency()
    {
        $currencyData = Currency::factory()->raw();

        $response = $this->json('POST', route('admin.currencies.store'), $currencyData);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'iso_code',
                'is_main',
            ]
        ]);

        $this->assertDatabaseHas('currencies', [
            'name' => $currencyData['name'],
        ]);
    }
}
