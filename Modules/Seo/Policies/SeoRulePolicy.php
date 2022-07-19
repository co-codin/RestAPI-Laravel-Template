<?php

namespace Modules\Seo\Policies;

use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Seo\Enums\SeoRulePermission;
use Modules\Seo\Models\SeoRule;
use Modules\User\Models\User;

class SeoRulePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(SeoRulePermission::VIEW_SEO_RULES);
    }

    public function view(User $user, SeoRule $seo_rule): bool
    {
        return $user->can(SeoRulePermission::VIEW_SEO_RULES);
    }

    public function create(User $user): bool
    {
        return $user->can(SeoRulePermission::CREATE_SEO_RULES);
    }

    public function update(User $user, SeoRule $seo_rule): bool
    {
        return $user->can(SeoRulePermission::EDIT_SEO_RULES);
    }

    public function delete(User $user, SeoRule $seo_rule): bool
    {
        return $user->can(SeoRulePermission::DELETE_SEO_RULES);
    }
}
