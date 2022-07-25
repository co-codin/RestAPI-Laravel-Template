<?php

namespace Modules\Cabinet\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Cabinet\Enums\CabinetPermission;
use Modules\Cabinet\Models\Cabinet;
use Modules\User\Models\User;

class CabinetPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(CabinetPermission::VIEW_CABINETS);
    }

    public function view(User $user, Cabinet $cabinet): bool
    {
        return $user->can(CabinetPermission::VIEW_CABINETS);
    }

    public function create(User $user): bool
    {
        return $user->can(CabinetPermission::CREATE_CABINETS);
    }

    public function update(User $user, Cabinet $cabinet): bool
    {
        return $user->can(CabinetPermission::EDIT_CABINETS);
    }

    public function delete(User $user, Cabinet $cabinet): bool
    {
        return $user->can(CabinetPermission::DELETE_CABINETS);
    }
}
