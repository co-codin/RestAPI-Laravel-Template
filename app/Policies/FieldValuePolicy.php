<?php

namespace App\Policies;

use App\Enums\FieldValuePermission;
use App\Models\FieldValue;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;

class FieldValuePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(FieldValuePermission::VIEW_FIELD_VALUES);
    }

    public function view(User $user, FieldValue $fieldValue): bool
    {
        return $user->can(FieldValuePermission::VIEW_FIELD_VALUES);
    }

    public function create(User $user): bool
    {
        return $user->can(FieldValuePermission::CREATE_FIELD_VALUES);
    }

    public function update(User $user, FieldValue $fieldValue): bool
    {
        return $user->can(FieldValuePermission::EDIT_FIELD_VALUES);
    }

    public function delete(User $user, FieldValue $fieldValue): bool
    {
        return $user->can(FieldValuePermission::DELETE_FIELD_VALUES);
    }
}
