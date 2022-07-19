<?php

namespace Modules\Seo\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Seo\Enums\CanonicalPermission;
use Modules\Seo\Models\Canonical;
use Modules\User\Models\User;

class CanonicalPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(CanonicalPermission::VIEW_CANONICALS);
    }

    public function view(User $user, Canonical $canonical): bool
    {
        return $user->can(CanonicalPermission::VIEW_CANONICALS);
    }

    public function create(User $user): bool
    {
        return $user->can(CanonicalPermission::CREATE_CANONICALS);
    }

    public function update(User $user, Canonical $canonical): bool
    {
        return $user->can(CanonicalPermission::EDIT_CANONICALS);
    }

    public function delete(User $user, Canonical $canonical): bool
    {
        return $user->can(CanonicalPermission::DELETE_CANONICALS);
    }
}
