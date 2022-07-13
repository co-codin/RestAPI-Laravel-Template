<?php

namespace Modules\Role\Console;

use Illuminate\Console\Command;
use Modules\Role\Contracts\PermissionEnum;
use Modules\Role\Models\Permission;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

/**
 * Class SyncPermission
 * @package Modules\User\Console\Permissions
 */
class SyncPermissions extends Command
{
    protected $signature = 'permission:sync';

    protected $description = 'synchronize all permissions';

    public function handle()
    {
        $permissionFiles = Finder::create()
            ->in([
                base_path('Modules/*/Enums'),
                app_path('Enums')
            ])
            ->name('/Permission.php$/')
            ->files();

        $permissions = collect($permissionFiles)
            ->map(function(SplFileInfo $file) {
                return str_replace("/", "\\", str_replace(base_path(), "", $file->getPath())) . "\\" . $file->getBasename('.' . $file->getExtension());
            })
            ->filter(function(string $class) {
                return is_subclass_of($class, PermissionEnum::class);
            })
            ->map(function($class) {
                return $class::descriptions();
            })
            ->collapse()
            ->each(function($description, $name) {
                Permission::updateOrCreate(
                    ['name' => $name],
                    ['description' => $description, 'guard_name' => 'api']
                );
            });

        Permission::whereNotIn('name', $permissions->keys())->delete();
    }
}
