<?php

namespace Modules\Export\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Export\Enum\ExportPermission;
use Modules\Export\Models\Export;
use Modules\User\Models\User;

class ExportPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(ExportPermission::VIEW_EXPORTS);
    }

    public function view(User $user, Export $export): bool
    {
        return $user->can(ExportPermission::VIEW_EXPORTS);
    }

    public function create(User $user): bool
    {
        return $user->can(ExportPermission::CREATE_EXPORTS);
    }

    public function update(User $user, Export $export): bool
    {
        return $user->can(ExportPermission::EDIT_EXPORTS);
    }

    public function delete(User $user, Export $export): bool
    {
        return $user->can(ExportPermission::DELETE_EXPORTS);
    }

    public function export(User $user, Export $export): bool
    {
        return $user->can(ExportPermission::EXPORT_EXPORTS);
    }
}
