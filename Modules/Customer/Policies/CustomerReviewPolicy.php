<?php

namespace Modules\Customer\Policies;

use App\Policies\BasePolicy;
use Google\Service\Reseller\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Customer\Enums\CustomerReviewPermission;
use Modules\User\Models\User;

class CustomerReviewPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(CustomerReviewPermission::VIEW_CUSTOMERS);
    }

    public function view(User $user, Customer $customer): bool
    {
        return $user->can(CustomerReviewPermission::VIEW_CUSTOMERS);
    }

    public function create(User $user): bool
    {
        return $user->can(CustomerReviewPermission::CREATE_CUSTOMERS);
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->can(CustomerReviewPermission::EDIT_CUSTOMERS);
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->can(CustomerReviewPermission::DELETE_CUSTOMERS);
    }
}
