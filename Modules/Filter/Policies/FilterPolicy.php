<?php

namespace Modules\Filter\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Filter\Enums\FilterPermission;
use Modules\Filter\Models\Filter;
use Modules\User\Models\User;

class FilterPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(FilterPermission::VIEW_FILTERS);
    }

    public function view(User $user, Filter $filter): bool
    {
        return $user->can(FilterPermission::VIEW_FILTERS);
    }

    public function create(User $user): bool
    {
        return $user->can(FilterPermission::CREATE_FILTERS);
    }

    public function update(User $user, Filter $filter): bool
    {
        return $user->can(FilterPermission::EDIT_FILTERS);
    }

    public function delete(User $user, Filter $filter): bool
    {
        return $user->can(FilterPermission::DELETE_FILTERS);
    }

    public function sort(User $user): bool
    {
        return $user->can(FilterPermission::SORT_FILTERS);
    }
}
