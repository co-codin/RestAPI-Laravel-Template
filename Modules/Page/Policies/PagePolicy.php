<?php

namespace Modules\Page\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Page\Enums\PagePermission;
use Modules\Page\Models\Page;
use Modules\User\Models\User;

class PagePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(PagePermission::VIEW_PAGES);
    }

    public function view(User $user, Page $page): bool
    {
        return $user->can(PagePermission::VIEW_PAGES);
    }

    public function create(User $user): bool
    {
        return $user->can(PagePermission::CREATE_PAGES);
    }

    public function update(User $user, Page $page): bool
    {
        return $user->can(PagePermission::EDIT_PAGES);
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->can(PagePermission::DELETE_PAGES);
    }
}
