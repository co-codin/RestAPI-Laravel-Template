<?php

namespace Modules\Category\Policies;

use App\Policies\BasePolicy;
use Modules\Category\Enums\CategoryPermission;
use Modules\Category\Models\Category;
use Modules\User\Models\User;

class CategoryPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(CategoryPermission::VIEW_CATEGORIES);
    }

    public function view(User $user, Category $category): bool
    {
        return $user->can(CategoryPermission::VIEW_CATEGORIES);
    }

    public function create(User $user): bool
    {
        return $user->can(CategoryPermission::CREATE_CATEGORIES);
    }

    public function update(User $user, Category $category): bool
    {
        return $user->can(CategoryPermission::EDIT_CATEGORIES);
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->can(CategoryPermission::DELETE_CATEGORIES);
    }
}
