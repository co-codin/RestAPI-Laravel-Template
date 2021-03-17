<?php


namespace Modules\Achievement\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Modules\Achievement\Enums\AchievementStatus;
use Modules\Achievement\Models\Achievement;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AchievementType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Achievement',
        'description' => 'Достижение',
        'model' => Achievement::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID достижения'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Название достижения'
            ],
            'image' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'URL картинки достижения'
            ],
            'status' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Статус достижения',
                'resolve' => function($root, $args) {
                    return AchievementStatus::getValue($root->status);
                },
            ],
            'position' => [
                'type' => Type::int(),
                'description' => 'Позиция достижения',
            ],
        ];
    }
}
