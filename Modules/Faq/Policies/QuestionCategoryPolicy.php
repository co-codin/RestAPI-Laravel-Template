<?php

namespace Modules\Faq\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Faq\Enums\QuestionCategoryPermission;
use Modules\Faq\Models\QuestionCategory;
use Modules\User\Models\User;

class QuestionCategoryPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(QuestionCategoryPermission::VIEW_QUESTION_CATEGORIES);
    }

    public function view(User $user, QuestionCategory $question_category): bool
    {
        return $user->can(QuestionCategoryPermission::VIEW_QUESTION_CATEGORIES);
    }

    public function create(User $user): bool
    {
        return $user->can(QuestionCategoryPermission::CREATE_QUESTION_CATEGORIES);
    }

    public function update(User $user, QuestionCategory $question_category): bool
    {
        return $user->can(QuestionCategoryPermission::EDIT_QUESTION_CATEGORIES);
    }

    public function delete(User $user, QuestionCategory $question_category): bool
    {
        return $user->can(QuestionCategoryPermission::DELETE_QUESTION_CATEGORIES);
    }

    public function sort(User $user): bool
    {
        return $user->can(QuestionCategoryPermission::SORT_QUESTION_CATEGORIES);
    }
}
