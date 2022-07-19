<?php

namespace Modules\Currency\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Currency\Enums\CurrencyPermission;
use Modules\Currency\Models\Currency;
use Modules\User\Models\User;

class CurrencyPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(CurrencyPermission::VIEW_CURRENCIES);
    }

    public function view(User $user, Currency $currency): bool
    {
        return $user->can(CurrencyPermission::VIEW_CURRENCIES);
    }

    public function create(User $user): bool
    {
        return $user->can(CurrencyPermission::CREATE_CURRENCIES);
    }

    public function update(User $user, Currency $currency): bool
    {
        return $user->can(CurrencyPermission::EDIT_CURRENCIES);
    }

    public function delete(User $user, Currency $currency): bool
    {
        return $user->can(CurrencyPermission::DELETE_CURRENCIES);
    }
}
