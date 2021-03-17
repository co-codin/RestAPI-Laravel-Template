<?php


namespace Modules\Achievement\GraphQL\Queries;

use Closure;
use Modules\Achievement\Models\Achievement;
use Modules\Achievement\Repositories\AchievementRepository;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class AchievementQuery extends Query
{
    protected $achievementRepository;

    protected $attributes = [
        'name' => 'achievements',
    ];

    public function __construct(AchievementRepository $achievementRepository)
    {
        $this->achievementRepository = $achievementRepository;
        $this->achievementRepository->pushCriteria();
    }

    public function type(): Type
    {
        return GraphQL::paginate('achievement');
    }

    public function args(): array
    {
        return [
            'name' => ['name' => 'name', 'type' => Type::string()],
            'limit' => ['name' => 'limit', 'type' => Type::int()],
            'page' => ['name' => 'page', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->achievementRepository->paginate(
            $args['limit'], ['*']
        );
    }
}
