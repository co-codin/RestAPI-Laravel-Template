<?php


namespace Tests\Feature\Auth;


use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login()
    {
        $response = Http::post(config('services.auth.url') . '/api/auth/login', $this->getData());

        dd(
            $response->status()
        );
    }

    protected function getData()
    {
        return [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ];
    }
}
