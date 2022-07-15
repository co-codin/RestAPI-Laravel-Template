<?php

namespace Modules\Banner\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Banner\Enums\BannerPermission;
use Modules\Banner\Models\Banner;
use Modules\User\Models\User;

class BannerPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(BannerPermission::VIEW_BANNERS);
    }

    public function view(User $user, Banner $banner): bool
    {
        return $user->can(BannerPermission::VIEW_BANNERS);
    }

    public function create(User $user): bool
    {
        return $user->can(BannerPermission::CREATE_BANNERS);
    }

    public function update(User $user, Banner $banner): bool
    {
        return $user->can(BannerPermission::EDIT_BANNERS);
    }

    public function delete(User $user, Banner $banner): bool
    {
        return $user->can(BannerPermission::DELETE_BANNERS);
    }
}
