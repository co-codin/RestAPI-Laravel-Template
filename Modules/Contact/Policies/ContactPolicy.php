<?php

namespace Modules\Contact\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Contact\Enums\ContactPermission;
use Modules\Contact\Models\Contact;
use Modules\User\Models\User;

class ContactPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(ContactPermission::VIEW_CONTACTS);
    }

    public function view(User $user, Contact $contact): bool
    {
        return $user->can(ContactPermission::VIEW_CONTACTS);
    }

    public function create(User $user): bool
    {
        return $user->can(ContactPermission::CREATE_CONTACTS);
    }

    public function update(User $user, Contact $contact): bool
    {
        return $user->can(ContactPermission::EDIT_CONTACTS);
    }

    public function delete(User $user, Contact $contact): bool
    {
        return $user->can(ContactPermission::DELETE_CONTACTS);
    }

    public function sort(User $user, Contact $contact): bool
    {
        return $user->can(ContactPermission::SORT_CONTACTS);
    }
}
