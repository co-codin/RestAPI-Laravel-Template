<?php


namespace Modules\Achievement\Builders;

use Modules\Achievement\Models\Achievement;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Query\Builder;

class AchievementBuilder
{
    public function admin($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Builder
    {
        return auth('api')->check() ? Achievement::query()->toBase() : new Builder();
    }
}
