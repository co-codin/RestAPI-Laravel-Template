<?php

namespace Modules\Redirect\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Redirect\Enums\RedirectPermission;
use Modules\Redirect\Models\Redirect;
use Modules\User\Models\User;

class RedirectPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(RedirectPermission::VIEW_REDIRECTS);
    }

    public function view(User $user, Redirect $redirect): bool
    {
        return $user->can(RedirectPermission::VIEW_REDIRECTS);
    }

    public function create(User $user): bool
    {
        return $user->can(RedirectPermission::CREATE_REDIRECTS);
    }

    public function update(User $user, Redirect $redirect): bool
    {
        return $user->can(RedirectPermission::EDIT_REDIRECTS);
    }

    public function delete(User $user, Redirect $redirect): bool
    {
        return $user->can(RedirectPermission::DELETE_REDIRECTS);
    }
}
