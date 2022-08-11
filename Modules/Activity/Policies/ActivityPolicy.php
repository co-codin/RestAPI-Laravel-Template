<?php

namespace Modules\Activity\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Activity\Enums\ActivityPermission;
use Modules\User\Models\User;

class ActivityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(ActivityPermission::VIEW_ACTIVITY_LOG);
    }
}
