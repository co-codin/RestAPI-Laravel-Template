<?php

namespace Modules\Faq\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Faq\Enums\QuestionPermission;
use Modules\Faq\Models\Question;
use Modules\User\Models\User;

class QuestionPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(QuestionPermission::VIEW_QUESTIONS);
    }

    public function view(User $user, Question $question): bool
    {
        return $user->can(QuestionPermission::VIEW_QUESTIONS);
    }

    public function create(User $user): bool
    {
        return $user->can(QuestionPermission::CREATE_QUESTIONS);
    }

    public function update(User $user, Question $question): bool
    {
        return $user->can(QuestionPermission::EDIT_QUESTIONS);
    }

    public function delete(User $user, Question $question): bool
    {
        return $user->can(QuestionPermission::DELETE_QUESTIONS);
    }
}
