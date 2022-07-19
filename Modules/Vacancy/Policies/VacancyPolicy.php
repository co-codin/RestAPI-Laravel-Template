<?php

namespace Modules\Vacancy\Policies;

use App\Policies\BasePolicy;
use Modules\User\Models\User;
use Modules\Vacancy\Enums\VacancyPermission;
use Modules\Vacancy\Models\Vacancy;

class VacancyPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(VacancyPermission::VIEW_VACANCIES);
    }

    public function view(User $user, Vacancy $vacancy): bool
    {
        return $user->can(VacancyPermission::VIEW_VACANCIES);
    }

    public function create(User $user): bool
    {
        return $user->can(VacancyPermission::CREATE_VACANCIES);
    }

    public function update(User $user, Vacancy $vacancy): bool
    {
        return $user->can(VacancyPermission::EDIT_VACANCIES);
    }

    public function delete(User $user, Vacancy $vacancy): bool
    {
        return $user->can(VacancyPermission::DELETE_VACANCIES);
    }
}
