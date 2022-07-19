<?php

namespace Modules\Publication\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Publication\Enums\PublicationPermission;
use Modules\Publication\Models\Publication;
use Modules\User\Models\User;

class PublicationPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(PublicationPermission::VIEW_PUBLICATIONS);
    }

    public function view(User $user, Publication $publication): bool
    {
        return $user->can(PublicationPermission::VIEW_PUBLICATIONS);
    }

    public function create(User $user): bool
    {
        return $user->can(PublicationPermission::CREATE_PUBLICATIONS);
    }

    public function update(User $user, Publication $publication): bool
    {
        return $user->can(PublicationPermission::EDIT_PUBLICATIONS);
    }

    public function delete(User $user, Publication $publication): bool
    {
        return $user->can(PublicationPermission::DELETE_PUBLICATIONS);
    }
}
