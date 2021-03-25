<?php


namespace Tests\Feature\Auth;


use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login()
    {
        $response = Http::post(config('services.auth.url') . '/api/auth/login', $this->getRightData());
        $this->assertEquals($response->status(), 200);

        $response = Http::post(config('services.auth.url') . '/api/auth/login', $this->getWrongData());
        $this->assertEquals($response->status(), 422);
    }

    public function test_me()
    {
        $response = Http::post(config('services.auth.url') . '/api/auth/login', $this->getRightData());

        $response = Http::withToken($response['token'])->get(config('services.auth.url') . '/api/auth/user');

        $this->assertEquals($response->status(), 200);
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
