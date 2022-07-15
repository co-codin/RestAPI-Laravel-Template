<?php

namespace Modules\Brand\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Brand\Enums\BrandPermission;
use Modules\Brand\Models\Brand;
use Modules\User\Models\User;

class BrandPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(BrandPermission::VIEW_BRANDS);
    }

    public function view(User $user, Brand $brand): bool
    {
        return $user->can(BrandPermission::VIEW_BRANDS);
    }

    public function create(User $user): bool
    {
        return $user->can(BrandPermission::CREATE_BRANDS);
    }

    public function update(User $user, Brand $brand): bool
    {
        return $user->can(BrandPermission::EDIT_BRANDS);
    }

    public function delete(User $user, Brand $brand): bool
    {
        return $user->can(BrandPermission::DELETE_BRANDS);
    }

    public function updateSeo(User $user, Brand $brand)
    {
        return $user->can(BrandPermission::UPDATE_BRAND_SEO);
    }
}
