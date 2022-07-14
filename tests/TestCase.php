<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Modules\Role\Enums\DefaultRole;
use Modules\Role\Models\Role;
use Modules\User\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake();
        Storage::fake('public');
    }

    protected function authenticateUser()
    {
        User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }

    protected function authenticateAdmin()
    {
        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $role = Role::factory()->create([
            'name' => DefaultRole::ADMIN
        ]);

        $user->roles()->sync($role);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));
    }
}
