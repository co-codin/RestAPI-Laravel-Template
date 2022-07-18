<?php

namespace Modules\News\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\News\Enums\NewsPermission;
use Modules\News\Models\News;
use Modules\User\Models\User;

class NewsPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(NewsPermission::VIEW_NEWS);
    }

    public function view(User $user, News $news): bool
    {
        return $user->can(NewsPermission::VIEW_NEWS);
    }

    public function create(User $user): bool
    {
        return $user->can(NewsPermission::CREATE_NEWS);
    }

    public function update(User $user, News $news): bool
    {
        return $user->can(NewsPermission::EDIT_NEWS);
    }

    public function delete(User $user, News $news): bool
    {
        return $user->can(NewsPermission::DELETE_NEWS);
    }
}
