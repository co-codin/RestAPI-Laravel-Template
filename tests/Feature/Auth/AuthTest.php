<?php


namespace Tests\Feature\Auth;


use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login_endpoint()
    {
        $response = $this->json('POST', route('auth.login'), $this->getRightData());

        $response->assertStatus(200);

        $response = $this->json('POST', route('auth.login'), $this->getWrongData());

        $response->assertStatus(404);
    }

    public function test_me_api()
    {
        $response = Http::post(config('services.auth.url') . '/api/auth/login', $this->getRightData());

        $response = Http::withToken($response['token'])->get(config('services.auth.url') . '/api/auth/user');

        $this->assertEquals($response->status(), 200);
    }

    public function test_me_endpoint()
    {
        $this->json('POST', route('auth.login'), $this->getRightData());

        $response = $this->json('GET', route('auth.user'));

        $response->assertStatus(200);

        $this->assertNotEmpty($response->json());
    }

    public function test_me_endpoint_opposite()
    {
        $response = $this->json('GET', route('auth.user'));

        $response->assertStatus(401);
    }

    public function test_logout()
    {
        $this->json('POST', route('auth.login'), $this->getRightData());

        $response = $this->json('POST', route('auth.logout'), $this->getRightData());

        $response->assertStatus(200);
        $this->assertEmpty(session()->get('access_token'));
    }

    protected function getRightData()
    {
        return [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ];
    }

    protected function getWrongData()
    {
        return [
            'email' => 'adm@medeq.ru',
            'password' => 'admin1',
        ];
    }
}
