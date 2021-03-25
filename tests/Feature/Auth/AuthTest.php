<?php


namespace Tests\Feature\Auth;


use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login_api()
    {
        $response = Http::post(config('services.auth.url') . '/api/auth/login', $this->getRightData());
        $this->assertEquals($response->status(), 200);

        $response = Http::post(config('services.auth.url') . '/api/auth/login', $this->getWrongData());
        $this->assertEquals($response->status(), 422);
    }

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

        dd(
            $response->content()
        );
//        $response->assertStatus(200);

//        dd(
//            $response->json()
//        );
//        $this->assertEquals($response->status(), 200);
    }

    public function logout()
    {

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
