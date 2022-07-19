<?php

namespace Modules\Attribute\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Attribute\Enums\AttributePermission;
use Modules\Attribute\Models\Attribute;
use Modules\User\Models\User;

class AttributePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(AttributePermission::VIEW_ATTRIBUTES);
    }

    public function view(User $user, Attribute $attribute): bool
    {
        return $user->can(AttributePermission::VIEW_ATTRIBUTES);
    }

    public function create(User $user): bool
    {
        return $user->can(AttributePermission::CREATE_ATTRIBUTES);
    }

    public function update(User $user, Attribute $attribute): bool
    {
        return $user->can(AttributePermission::EDIT_ATTRIBUTES);
    }

    public function delete(User $user, Attribute $attribute): bool
    {
        return $user->can(AttributePermission::DELETE_ATTRIBUTES);
    }
}
