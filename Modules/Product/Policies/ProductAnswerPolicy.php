<?php

namespace Modules\Product\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Product\Enums\ProductAnswerPermission;
use Modules\Product\Models\ProductAnswer;
use Modules\User\Models\User;

class ProductAnswerPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(ProductAnswerPermission::VIEW_PRODUCT_ANSWERS);
    }

    public function view(User $user, ProductAnswer $product_answer): bool
    {
        return $user->can(ProductAnswerPermission::VIEW_PRODUCT_ANSWERS);
    }

    public function create(User $user): bool
    {
        return $user->can(ProductAnswerPermission::CREATE_PRODUCT_ANSWERS);
    }

    public function update(User $user, ProductAnswer $product_answer): bool
    {
        return $user->can(ProductAnswerPermission::EDIT_PRODUCT_ANSWERS);
    }

    public function delete(User $user, ProductAnswer $product_answer): bool
    {
        return $user->can(ProductAnswerPermission::DELETE_PRODUCT_ANSWERS);
    }
}
