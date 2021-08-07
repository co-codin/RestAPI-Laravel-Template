<?php


namespace Tests\Feature\Modules\Geo\Web;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class DetectIpTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('dl:integrate');
    }

    public function test_ip_can_be_detected()
    {
        $ip = '195.70.192.0';

        $response = $this->json('GET', route('geo.detect_ip'), ['ip' => $ip]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "city_name" => "Санкт-Петербург"
        ]);
    }
}
