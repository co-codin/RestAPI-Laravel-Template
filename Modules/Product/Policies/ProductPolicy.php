<?php

namespace Modules\Product\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Product\Enums\ProductPermission;
use Modules\Product\Models\Product;
use Modules\User\Models\User;

class ProductPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(ProductPermission::VIEW_PRODUCTS);
    }

    public function view(User $user, Product $product): bool
    {
        return $user->can(ProductPermission::VIEW_PRODUCTS);
    }

    public function create(User $user): bool
    {
        return $user->can(ProductPermission::CREATE_PRODUCTS);
    }

    public function update(User $user, Product $product): bool
    {
        return $user->can(ProductPermission::EDIT_PRODUCTS);
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->can(ProductPermission::DELETE_PRODUCTS);
    }
}
