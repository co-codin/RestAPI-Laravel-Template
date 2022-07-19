<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Role\Models\Role;
use Modules\User\Models\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $user->roles()->sync(Role::find(1)); // admin role

        // $this->call("OthersTableSeeder");
    }
}
