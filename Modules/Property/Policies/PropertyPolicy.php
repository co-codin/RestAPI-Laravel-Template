<?php

namespace Modules\Property\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Property\Enums\PropertyPermission;
use Modules\Property\Models\Property;
use Modules\User\Models\User;

class PropertyPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(PropertyPermission::VIEW_PROPERTIES);
    }

    public function view(User $user, Property $property): bool
    {
        return $user->can(PropertyPermission::VIEW_PROPERTIES);
    }

    public function create(User $user): bool
    {
        return $user->can(PropertyPermission::CREATE_PROPERTIES);
    }

    public function update(User $user, Property $property): bool
    {
        return $user->can(PropertyPermission::EDIT_PROPERTIES);
    }

    public function delete(User $user, Property $property): bool
    {
        return $user->can(PropertyPermission::DELETE_PROPERTIES);
    }
}
