<?php

namespace Modules\Case\Policies;

use App\Policies\BasePolicy;
use Modules\Case\Enums\CasePermission;
use Modules\Case\Models\CaseModel;
use Modules\User\Models\User;

class CasePolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(CasePermission::VIEW_CASES);
    }

    public function view(User $user, CaseModel $case): bool
    {
        return $user->can(CasePermission::VIEW_CASES);
    }

    public function create(User $user): bool
    {
        return $user->can(CasePermission::CREATE_CASES);
    }

    public function update(User $user, CaseModel $case): bool
    {
        return $user->can(CasePermission::EDIT_CASES);
    }

    public function delete(User $user, CaseModel $case): bool
    {
        return $user->can(CasePermission::DELETE_CASES);
    }
}
