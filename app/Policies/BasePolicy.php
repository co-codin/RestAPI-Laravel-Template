<?php

namespace App\Policies;

use Modules\Role\Enums\DefaultRole;
use Modules\User\Models\User;

abstract class BasePolicy
{
    protected function isAdmin(User $user): bool
    {
        return $user->hasRole(DefaultRole::ADMIN);
    }
}
