<?php

namespace Modules\Review\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Review\Enums\ProductReviewPermission;
use Modules\Review\Models\ProductReview;
use Modules\User\Models\User;

class ProductReviewPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(ProductReviewPermission::VIEW_PRODUCT_REVIEWS);
    }

    public function view(User $user, ProductReview $product_review): bool
    {
        return $user->can(ProductReviewPermission::VIEW_PRODUCT_REVIEWS);
    }

    public function create(User $user): bool
    {
        return $user->can(ProductReviewPermission::CREATE_PRODUCT_REVIEWS);
    }

    public function update(User $user, ProductReview $product_review): bool
    {
        return $user->can(ProductReviewPermission::EDIT_PRODUCT_REVIEWS);
    }

    public function delete(User $user, ProductReview $product_review): bool
    {
        return $user->can(ProductReviewPermission::DELETE_PRODUCT_REVIEWS);
    }

    public function approve(User $user, ProductReview $product_review): bool
    {
        return $user->can(ProductReviewPermission::APPROVE_PRODUCT_REVIEWS);
    }

    public function reject(User $user, ProductReview $product_review): bool
    {
        return $user->can(ProductReviewPermission::REJECT_PRODUCT_REVIEWS);
    }
}
