<?php

namespace App\GraphQL\Directives;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Http;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class JwtDirective extends BaseDirective implements FieldMiddleware
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'GRAPHQL'
        """
        check jwt auth
        """
        directive @jwt on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
        GRAPHQL;
    }

    public function handleField(FieldValue $fieldValue, Closure $next)
    {
        $previousResolver = $fieldValue->getResolver();

        $wrappedResolver = function ($root, array $args, GraphQLContext $context, ResolveInfo $info) use ($previousResolver): string {
            /** @var string $result */
            $result = $previousResolver($root, $args, $context, $info);
            return $this->verifyToken(request()->bearerToken()) ? $result : '';
        };

        $fieldValue->setResolver($wrappedResolver);

        return $next($fieldValue);
    }

    protected function verifyToken($token)
    {
        $response = Http::withToken($token)->get(config('services.auth.url') . '/api/auth/user');

        return $response->successful();
    }
}
