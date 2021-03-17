<?php


namespace Modules\Achievement\GraphQL\Queries;

use Closure;
use Modules\Achievement\Models\Achievement;
use Modules\Achievement\Repositories\AchievementRepository;
use Modules\Achievement\Repositories\Criteria\AchievementRequestCriteria;
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
    }

    public function type(): Type
    {
        return GraphQL::paginate('achievement');
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'name' => ['name' => 'name', 'type' => Type::string()],
            'image' => ['name' => 'image', 'type' => Type::string()],
            'status' => ['name' => 'status', 'type' => Type::int()],

            'limit' => ['name' => 'limit', 'type' => Type::int()],
            'page' => ['name' => 'page', 'type' => Type::int()],

        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $this->achievementRepository->pushCriteria(new AchievementRequestCriteria($args));

        return $this->achievementRepository->paginate(
            $args['limit'], ['*']
        );
    }
}
