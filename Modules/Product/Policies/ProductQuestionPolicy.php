<?php

namespace Modules\Product\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Product\Enums\ProductQuestionPermission;
use Modules\Product\Models\ProductQuestion;
use Modules\User\Models\User;

class ProductQuestionPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(ProductQuestionPermission::VIEW_PRODUCT_QUESTIONS);
    }

    public function view(User $user, ProductQuestion $product_question): bool
    {
        return $user->can(ProductQuestionPermission::VIEW_PRODUCT_QUESTIONS);
    }

    public function create(User $user): bool
    {
        return $user->can(ProductQuestionPermission::CREATE_PRODUCT_QUESTIONS);
    }

    public function update(User $user, ProductQuestion $product_question): bool
    {
        return $user->can(ProductQuestionPermission::EDIT_PRODUCT_QUESTIONS);
    }

    public function delete(User $user, ProductQuestion $product_question): bool
    {
        return $user->can(ProductQuestionPermission::DELETE_PRODUCT_QUESTIONS);
    }

    public function approve(User $user, ProductQuestion $product_question): bool
    {
        return $user->can(ProductQuestionPermission::APPROVE_PRODUCT_QUESTIONS);
    }

    public function reject(User $user, ProductQuestion $product_question): bool
    {
        return $user->can(ProductQuestionPermission::REJECT_PRODUCT_QUESTIONS);
    }
}
