<?php


namespace Tests\Feature\Modules\Geo\Web;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class DetectCityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
        Artisan::call('import:order_points');
    }

    public function test_ip_can_be_detected()
    {
        $response = $this->json('GET', route('geo.detect_city'), [], ['REMOTE_ADDR' => '93.0.4577.63']);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "name" => "Москва"
        ]);
    }
}
