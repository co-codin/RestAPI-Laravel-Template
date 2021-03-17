<?php


namespace Modules\Achievement\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AchievementType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Achievement',
        'description' => 'Достижение',
//        'model' =>
    ];
}
