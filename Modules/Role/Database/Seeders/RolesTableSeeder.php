<?php

namespace Modules\Role\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Role\Enums\PermissionLevel;
use Modules\Role\Models\Permission;
use Modules\Role\Models\Role;

class RolesTableSeeder extends Seeder
{
    protected $roles = [
        'Администратор' => '*',
        'Продакт' => '*',
    ];

    public function run()
    {
        $this->seedRoles();
    }

    protected function seedRoles()
    {
        foreach ($this->roles as $name => $permissions)
        {
            $role = Role::firstOrCreate([
                'name' => $name,
                'guard_name' => 'api',
            ]);

            $permissions = $permissions !== "*" ? $permissions: $this->prepareAllPermissions();

            $permissionRecords = Permission::whereIn('name', array_keys($permissions))
                ->get()
                ->mapWithKeys(function(Permission $permission) use ($permissions) {
                    return [$permission->id => ['level' => $permissions[$permission->name]]];
                })
                ->toArray();

            $role->permissions()->sync($permissionRecords);
        }
    }

    protected function prepareAllPermissions() : array
    {
        return Permission::all()
            ->mapWithKeys(function(Permission $permission) {
                return [$permission->name => PermissionLevel::ANY];
            })
            ->toArray();
    }
}
