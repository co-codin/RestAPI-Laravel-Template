<?php

namespace Modules\Achievement\Policies;

use Modules\Achievement\Enums\AchievementPermission;
use Modules\Achievement\Models\Achievement;
use Modules\User\Models\User;

class AchievementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(AchievementPermission::VIEW_ACHIEVEMENTS);
    }

    public function view(User $user, Achievement $achievement): bool
    {
        return $user->can(AchievementPermission::VIEW_ACHIEVEMENTS);
    }

    public function create(User $user): bool
    {
        return $user->can(AchievementPermission::CREATE_ACHIEVEMENTS);
    }

    public function update(User $user, Achievement $achievement): bool
    {
        return $user->can(AchievementPermission::EDIT_ACHIEVEMENTS);
    }

    public function delete(User $user, Achievement $achievement): bool
    {
        return $user->can(AchievementPermission::DELETE_ACHIEVEMENTS);
    }

    public function sort(User $user): bool
    {
        return $user->can(AchievementPermission::SORT_ACHIEVEMENTS);
    }
}
