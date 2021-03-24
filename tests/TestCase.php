<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, MakesGraphQLRequests, RefreshDatabase;

    protected function getToken()
    {
        $data = [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ];

        $response = Http::post(config('services.auth.url') . '/api/auth/login', $data);

        return $response->json()['token'];
    }
}
